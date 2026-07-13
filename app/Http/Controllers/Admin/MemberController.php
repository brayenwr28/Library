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
        $headers = ['No', 'NIM', 'Nama Lengkap', 'NIK', 'Program Studi', 'Tempat Lahir', 'Tanggal Lahir'];
        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $header);
        }

        // Style header
        $headerRange = 'A1:G1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E40AF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);

        // Contoh data
        $examples = [
            [1, '2021001001', 'Budi Santoso', '', 'Sistem Informasi', 'Jakarta', '2001-05-15'],
            [2, '', 'Dr. Ahmad', '198008122005011002', 'Teknik Informatika', 'Padang', '1980-08-12'],
        ];
        foreach ($examples as $rowIdx => $row) {
            foreach ($row as $colIdx => $value) {
                $cell = chr(65 + $colIdx) . ($rowIdx + 2);
                $sheet->setCellValue($cell, $value);
            }
        }

        // Style example rows
        $sheet->getStyle('A2:G3')->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFF6FF']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFDBFE']]],
            'font' => ['italic' => true, 'color' => ['rgb' => '6B7280']],
        ]);

        // Auto width
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Petunjuk di bawah contoh
        $sheet->setCellValue('A5', '* Hapus baris contoh (baris 2-3) sebelum mengisi data asli.');
        $sheet->setCellValue('A6', '* Jika Anggota adalah Mahasiswa, isi kolom NIM. Jika Dosen/Staff, isi kolom NIK.');
        $sheet->setCellValue('A7', '* Format Tanggal Lahir: YYYY-MM-DD (Contoh: 2001-05-15).');
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

                // Normalisasi header dan terjemahkan ke field internal
                $rawHeaders = [];
                foreach (array_values($sheetRows[array_key_first($sheetRows)]) as $h) {
                    $cleaned = strtolower(str_replace(' ', '_', trim((string) $h)));
                    if ($cleaned === 'nama_lengkap' || $cleaned === 'nama' || $cleaned === 'name') {
                        $rawHeaders[] = 'name';
                    } elseif ($cleaned === 'program_studi' || $cleaned === 'prodi') {
                        $rawHeaders[] = 'prodi';
                    } else {
                        $rawHeaders[] = $cleaned;
                    }
                }

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
                    $normalizedHeaders = [];
                    foreach ($headers as $h) {
                        $cleaned = strtolower(str_replace(' ', '_', trim($h)));
                        if ($cleaned === 'nama_lengkap' || $cleaned === 'nama' || $cleaned === 'name') {
                            $normalizedHeaders[] = 'name';
                        } elseif ($cleaned === 'program_studi' || $cleaned === 'prodi') {
                            $normalizedHeaders[] = 'prodi';
                        } else {
                            $normalizedHeaders[] = $cleaned;
                        }
                    }
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
        $existingNims = Member::whereNotNull('nim')->pluck('nim')->toArray();
        $existingNiks = Member::whereNotNull('nik')->pluck('nik')->toArray();
        $existingUsernames = Member::pluck('username')->toArray();

        $seenIds      = [];
        $seenEmails   = [];
        $seenNims     = [];
        $seenNiks     = [];
        $seenUsernames = [];

        $countValid   = 0;
        $countError   = 0;
        $countDuplikat = 0;

        $year = now()->format('Y');
        $baseSequence = Member::whereYear('tgl_daftar', $year)->count();

        foreach ($rawRows as $rowNum => $rowAssoc) {
            $name = $rowAssoc['name'] ?? '';
            $nim = !empty($rowAssoc['nim']) ? $rowAssoc['nim'] : null;
            $nik = !empty($rowAssoc['nik']) ? $rowAssoc['nik'] : null;
            $prodi = !empty($rowAssoc['prodi']) ? $rowAssoc['prodi'] : null;
            $tempatLahir = !empty($rowAssoc['tempat_lahir']) ? $rowAssoc['tempat_lahir'] : null;

            // Parse tanggal lahir
            $tanggalLahirRaw = $rowAssoc['tanggal_lahir'] ?? null;
            $tanggalLahir = null;
            if (!empty($tanggalLahirRaw)) {
                if (is_numeric($tanggalLahirRaw)) {
                    try {
                        $tanggalLahir = \Carbon\Carbon::instance(
                            \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalLahirRaw)
                        )->toDateString();
                    } catch (\Exception $e) {}
                } else {
                    try {
                        $cleanDateStr = str_replace('/', '-', $tanggalLahirRaw);
                        $tanggalLahir = \Carbon\Carbon::parse($cleanDateStr)->toDateString();
                    } catch (\Exception $e) {}
                }
            }

            // Tentukan role / jenis_anggota
            $jenisAnggota = 'mahasiswa';
            if (!empty($nik) && empty($nim)) {
                $jenisAnggota = 'dosen';
            }

            // Username
            $username = !empty($nim) ? $nim : (!empty($nik) ? $nik : null);
            if (empty($username) && !empty($name)) {
                $username = strtolower(str_replace(' ', '', $name)) . rand(100, 999);
            }

            // Email
            $email = ($username ? $username : 'anggota' . rand(100, 999)) . '@metamedia.ac.id';

            // Generate member_id
            $baseSequence++;
            $memberId = sprintf('PUS%s-%04d', $year, $baseSequence);

            $data = [
                'member_id'     => $memberId,
                'name'          => $name,
                'email'         => $email,
                'username'      => $username,
                'password'      => bcrypt('password123'),
                'nim'           => $nim,
                'nik'           => $nik,
                'prodi'         => $prodi,
                'tempat_lahir'  => $tempatLahir,
                'tanggal_lahir' => $tanggalLahir,
                'jenis_anggota' => $jenisAnggota,
                'tgl_daftar'    => now()->toDateString(),
            ];

            $rowErrors = [];
            $status    = 'valid';

            // Validasi dasar
            if (empty($data['name'])) {
                $rowErrors[] = 'Nama Lengkap harus diisi.';
            }
            if (empty($data['nim']) && empty($data['nik'])) {
                $rowErrors[] = 'NIM atau NIK harus diisi.';
            }

            if (!empty($rowErrors)) {
                $status = 'error';
                $countError++;
            } else {
                // Cek duplikasi database & upload batch
                $isDuplicate = false;

                if (!empty($data['nim'])) {
                    if (in_array($data['nim'], $existingNims) || in_array($data['nim'], $seenNims)) {
                        $rowErrors[] = 'NIM "' . $data['nim'] . '" sudah terdaftar.';
                        $isDuplicate = true;
                    }
                }

                if (!empty($data['nik'])) {
                    if (in_array($data['nik'], $existingNiks) || in_array($data['nik'], $seenNiks)) {
                        $rowErrors[] = 'NIK "' . $data['nik'] . '" sudah terdaftar.';
                        $isDuplicate = true;
                    }
                }

                if (in_array($data['username'], $existingUsernames) || in_array($data['username'], $seenUsernames)) {
                    $rowErrors[] = 'Username "' . $data['username'] . '" sudah digunakan.';
                    $isDuplicate = true;
                }

                if (in_array($data['email'], $existingEmails) || in_array($data['email'], $seenEmails)) {
                    $rowErrors[] = 'Email "' . $data['email'] . '" sudah terdaftar.';
                    $isDuplicate = true;
                }

                if ($isDuplicate) {
                    $status = 'duplikat';
                    $countDuplikat++;
                } else {
                    $countValid++;
                    if (!empty($data['nim'])) $seenNims[] = $data['nim'];
                    if (!empty($data['nik'])) $seenNiks[] = $data['nik'];
                    $seenUsernames[] = $data['username'];
                    $seenEmails[] = $data['email'];
                    $seenIds[] = $data['member_id'];
                }
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
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:members,email,' . $member->id],
            'nim'           => ['nullable', 'string', 'max:50', 'unique:members,nim,' . $member->id],
            'nik'           => ['nullable', 'string', 'max:50', 'unique:members,nik,' . $member->id],
            'prodi'         => ['nullable', 'string', 'max:100'],
            'tempat_lahir'  => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
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
