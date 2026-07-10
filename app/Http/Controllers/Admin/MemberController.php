<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberController extends Controller
{
    /**
     * Tampilkan form import, dengan data preview dari session jika ada.
     */
    public function importForm(Request $request): View
    {
        // Hapus preview jika user klik "Upload Ulang"
        if ($request->query('reset') === '1') {
            session()->forget('import_preview');
        }

        $preview = session('import_preview', null);
        return view('admin.members.import', compact('preview'));
    }

    /**
     * Download template Excel kosong untuk import anggota.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Anggota');

        // Headers
        $headers = ['member_id', 'name', 'email', 'nim', 'prodi', 'role'];
        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $header);
        }

        // Style header
        $headerRange = 'A1:F1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E40AF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);

        // Contoh data
        $examples = [
            ['MHS001', 'Budi Santoso', 'budi@metamedia.ac.id', '2021001001', 'Sistem Informasi', 'mahasiswa'],
            ['DSN001', 'Dr. Ahmad', 'ahmad@metamedia.ac.id', '', 'Teknik Informatika', 'dosen'],
        ];
        foreach ($examples as $rowIdx => $row) {
            foreach ($row as $colIdx => $value) {
                $cell = chr(65 + $colIdx) . ($rowIdx + 2);
                $sheet->setCellValue($cell, $value);
            }
        }

        // Style example rows
        $sheet->getStyle('A2:F3')->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFF6FF']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFDBFE']]],
            'font' => ['italic' => true, 'color' => ['rgb' => '6B7280']],
        ]);

        // Auto width
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Petunjuk di bawah contoh
        $sheet->setCellValue('A5', '* Hapus baris contoh (baris 2-3) sebelum mengisi data asli.');
        $sheet->setCellValue('A6', '* Kolom "role" diisi: mahasiswa atau dosen');
        $sheet->setCellValue('A7', '* Password default: password123 (anggota dapat menggantinya setelah login)');
        $sheet->getStyle('A5:A7')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('9CA3AF');

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'template_anggota.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Proses import: mode "preview" atau "confirm".
     */
    public function importProcess(Request $request): RedirectResponse
    {
        $mode = $request->input('mode', 'preview');

        // ── CONFIRM MODE: simpan data valid dari session ke DB ──────────────
        if ($mode === 'confirm') {
            $preview = session('import_preview');
            if (!$preview || empty($preview['rows'])) {
                return redirect()->route('admin.members.import.form')
                    ->with('error', 'Sesi preview telah habis. Silakan upload ulang file.');
            }

            $imported = 0;
            $failed   = 0;

            foreach ($preview['rows'] as $row) {
                if ($row['status'] !== 'valid') {
                    $failed++;
                    continue;
                }
                try {
                    Member::create($row['data']);
                    $imported++;
                } catch (\Exception $e) {
                    $failed++;
                }
            }

            session()->forget('import_preview');

            return redirect()->route('admin.report.anggota')
                ->with('success', "Import selesai: {$imported} anggota berhasil ditambahkan." .
                    ($failed > 0 ? " {$failed} baris dilewati." : ''));
        }

        // ── PREVIEW MODE: baca file, validasi, simpan ke session ────────────
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:10240'],
        ]);

        $path      = $request->file('csv_file')->getRealPath();
        $extension = strtolower($request->file('csv_file')->getClientOriginalExtension());
        $rawRows   = [];

        // Baca file
        try {
            if (in_array($extension, ['xlsx', 'xls'])) {
                $spreadsheet = IOFactory::load($path);
                $sheetRows   = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                if (empty($sheetRows)) {
                    return back()->withErrors(['csv_file' => 'File Excel kosong atau tidak valid.']);
                }

                $rawHeaders = array_map(
                    fn($h) => strtolower(str_replace(' ', '_', trim((string) $h))),
                    array_values($sheetRows[array_key_first($sheetRows)])
                );

                foreach ($sheetRows as $idx => $row) {
                    if ($idx === array_key_first($sheetRows)) continue;
                    $values = array_map(fn($v) => is_scalar($v) ? trim((string) $v) : '', array_values($row));
                    if (implode('', $values) === '') continue; // skip empty rows
                    $rawRows[] = array_combine($rawHeaders, $values);
                }
            } else {
                // CSV
                if (($handle = fopen($path, 'r')) !== false) {
                    $headers = fgetcsv($handle);
                    if ($headers === false) {
                        return back()->withErrors(['csv_file' => 'File CSV kosong atau tidak valid.']);
                    }
                    $normalizedHeaders = array_map(
                        fn($h) => strtolower(str_replace(' ', '_', trim($h))),
                        $headers
                    );
                    while (($row = fgetcsv($handle)) !== false) {
                        $row = array_map('trim', $row);
                        if (implode('', $row) === '') continue;
                        $rawRows[] = array_combine($normalizedHeaders, $row);
                    }
                    fclose($handle);
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors(['csv_file' => 'Gagal membaca file: ' . $e->getMessage()]);
        }

        if (empty($rawRows)) {
            return back()->withErrors(['csv_file' => 'Tidak ada data yang ditemukan di file.']);
        }

        // Validasi & analisis tiap baris
        $previewRows  = [];
        $existingIds  = Member::pluck('member_id')->toArray();
        $existingEmails = Member::pluck('email')->toArray();
        $seenIds      = [];
        $seenEmails   = [];
        $countValid   = 0;
        $countError   = 0;
        $countDuplikat = 0;

        foreach ($rawRows as $rowNum => $rowAssoc) {
            $email    = $rowAssoc['email'] ?? '';
            $username = $email ? explode('@', $email)[0] : ($rowAssoc['member_id'] ?? '');

            $data = [
                'member_id'     => $rowAssoc['member_id'] ?? '',
                'name'          => $rowAssoc['name'] ?? '',
                'email'         => $email,
                'username'      => $username,
                'password'      => bcrypt('password123'),
                'nim'           => $rowAssoc['nim'] ?? null,
                'prodi'         => $rowAssoc['prodi'] ?? null,
                'jenis_anggota' => isset($rowAssoc['role']) && strtolower($rowAssoc['role']) === 'dosen' ? 'dosen' : 'mahasiswa',
                'tgl_daftar'    => now()->toDateString(),
            ];

            $validator = Validator::make($data, [
                'member_id' => ['required', 'string', 'max:50'],
                'name'      => ['required', 'string', 'max:255'],
                'email'     => ['required', 'email', 'max:255'],
                'username'  => ['required', 'string', 'max:255'],
            ]);

            $rowErrors = [];
            $status    = 'valid';

            if ($validator->fails()) {
                $rowErrors = $validator->errors()->all();
                $status    = 'error';
                $countError++;
            } elseif (
                in_array($data['member_id'], $existingIds) ||
                in_array($data['member_id'], $seenIds)
            ) {
                $rowErrors[] = 'member_id "' . $data['member_id'] . '" sudah terdaftar.';
                $status      = 'duplikat';
                $countDuplikat++;
            } elseif (
                in_array($data['email'], $existingEmails) ||
                in_array($data['email'], $seenEmails)
            ) {
                $rowErrors[] = 'Email "' . $data['email'] . '" sudah terdaftar.';
                $status      = 'duplikat';
                $countDuplikat++;
            } else {
                $countValid++;
                $seenIds[]    = $data['member_id'];
                $seenEmails[] = $data['email'];
            }

            $previewRows[] = [
                'row_num' => $rowNum + 2, // +2 karena baris 1 = header
                'status'  => $status,
                'errors'  => $rowErrors,
                'data'    => $data,
                'raw'     => $rowAssoc,
            ];
        }

        session(['import_preview' => [
            'rows'          => $previewRows,
            'count_valid'   => $countValid,
            'count_error'   => $countError,
            'count_duplikat' => $countDuplikat,
            'count_total'   => count($previewRows),
        ]]);

        return redirect()->route('admin.members.import.form');
    }

    /**
     * Menampilkan form edit anggota
     */
    public function edit(Member $member): View
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Memperbarui data anggota
     */
    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:members,email,' . $member->id],
            'nim'          => ['nullable', 'string', 'max:50'],
            'prodi'        => ['nullable', 'string', 'max:100'],
            'jenis_anggota' => ['required', 'string', 'in:mahasiswa,dosen'],
        ]);

        $member->update($validated);

        return redirect()->route('admin.report.anggota')
            ->with('success', 'Data anggota berhasil diperbarui');
    }

    /**
     * Menghapus data anggota
     */
    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()->route('admin.report.anggota')
            ->with('success', 'Data anggota berhasil dihapus');
    }
}
