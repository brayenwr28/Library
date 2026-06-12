<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use League\Csv\Reader;
use Illuminate\Http\RedirectResponse;

class MemberController extends Controller
{
    public function importForm(): View
    {
        return view('admin.members.import');
    }

    public function importProcess(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:10240'],
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $imported = 0;
        $errors = [];

        $extension = strtolower($request->file('csv_file')->getClientOriginalExtension());

        if (in_array($extension, ['xlsx', 'xls'])) {
            if (!class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
                return redirect()->route('admin.report.index')->withErrors(['csv_file' => 'Excel import requires phpoffice/phpspreadsheet. Please run: composer require phpoffice/phpspreadsheet']);
            }

            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                if (empty($rows)) {
                    return redirect()->route('admin.report.index')->withErrors(['csv_file' => 'Excel file is empty or malformed']);
                }

                $rawHeaders = array_values($rows[1]);
                $headers = array_map(function ($h) { return strtolower(str_replace(' ', '_', trim((string)$h))); }, $rawHeaders);

                $rowNumber = 1;
                foreach ($rows as $idx => $row) {
                    if ($idx === 1) continue;
                    $rowNumber++;
                    $values = array_values($row);
                    $values = array_map(function ($v) { return is_scalar($v) ? trim((string)$v) : $v; }, $values);
                    $rowAssoc = array_combine($headers, $values);

                    $email = $rowAssoc['email'] ?? null;
                    $username = explode('@', (string)$email)[0] ?? ($rowAssoc['member_id'] ?? null);

                    $data = [
                        'member_id' => $rowAssoc['member_id'] ?? null,
                        'name' => $rowAssoc['name'] ?? null,
                        'email' => $email,
                        'username' => $username,
                        'password' => bcrypt('password123'),
                        'nim' => $rowAssoc['nim'] ?? null,
                        'prodi' => $rowAssoc['prodi'] ?? null,
                        'jenis_anggota' => isset($rowAssoc['role']) && strtolower($rowAssoc['role']) === 'dosen' ? 'dosen' : 'mahasiswa',
                        'tgl_daftar' => now(),
                    ];

                    $validator = Validator::make($data, [
                        'member_id' => ['required', 'string', 'max:50', 'unique:members,member_id'],
                        'name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'email', 'max:255', 'unique:members,email'],
                        'username' => ['required', 'string', 'max:255', 'unique:members,username'],
                    ]);

                    if ($validator->fails()) {
                        $errors[] = "Row {$rowNumber}: " . implode('; ', $validator->errors()->all());
                        continue;
                    }

                    Member::create($data);
                    $imported++;
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.report.index')->withErrors(['csv_file' => 'Error reading Excel file: ' . $e->getMessage()]);
            }
        } else {
            if (($handle = fopen($path, 'r')) !== false) {
                $headers = fgetcsv($handle);
                if ($headers === false) {
                    return redirect()->route('admin.report.index')->withErrors(['csv_file' => 'CSV file is empty or malformed']);
                }

                $headers = array_map('trim', $headers);
                $normalizedHeaders = array_map(function ($h) { return strtolower(str_replace(' ', '_', $h)); }, $headers);
                $rowNumber = 1;
                while (($row = fgetcsv($handle)) !== false) {
                    $rowNumber++;
                    $row = array_map('trim', $row);
                    $rowAssoc = array_combine($normalizedHeaders, $row);

                    $email = $rowAssoc['email'] ?? null;
                    $username = explode('@', (string)$email)[0] ?? ($rowAssoc['member_id'] ?? null);

                    $data = [
                        'member_id' => $rowAssoc['member_id'] ?? null,
                        'name' => $rowAssoc['name'] ?? null,
                        'email' => $email,
                        'username' => $username,
                        'password' => bcrypt('password123'),
                        'nim' => $rowAssoc['nim'] ?? null,
                        'prodi' => $rowAssoc['prodi'] ?? null,
                        'jenis_anggota' => isset($rowAssoc['role']) && strtolower($rowAssoc['role']) === 'dosen' ? 'dosen' : 'mahasiswa',
                        'tgl_daftar' => now(),
                    ];

                    $validator = Validator::make($data, [
                        'member_id' => ['required', 'string', 'max:50', 'unique:members,member_id'],
                        'name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'email', 'max:255', 'unique:members,email'],
                        'username' => ['required', 'string', 'max:255', 'unique:members,username'],
                    ]);

                    if ($validator->fails()) {
                        $errors[] = "Row {$rowNumber}: " . implode('; ', $validator->errors()->all());
                        continue;
                    }

                    Member::create($data);
                    $imported++;
                }

                fclose($handle);
            }
        }

        $message = "Imported {$imported} members.";
        if (!empty($errors)) {
            return redirect()->route('admin.report.index')->with('warning', $message . ' Some rows skipped: ' . implode(' | ', array_slice($errors, 0, 5)));
        }

        return redirect()->route('admin.report.index')->with('success', $message);
    }
}
