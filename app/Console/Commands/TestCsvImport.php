<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class TestCsvImport extends Command
{
    protected $signature = 'test:csv-import';
    protected $description = 'Test CSV import functionality for books and members';

    public function handle()
    {
        $this->info('=== CSV Import Test ===');

        // Test 1: CSV Book Import
        $this->line("\nTEST 1: Import Buku (CSV)");
        $this->line('---');

        $timestamp = now()->timestamp;
        $csvContent = <<<CSV
title,author,publisher,publication_year,category,summary,isbn,stock,cover_url,reference_url,status
Test Book {$timestamp} 1,John Doe,PT Publisher,2024,Fiksi,Ringkasan buku test CSV,978-5-{$timestamp}-1,5,,https://example.com,available
Test Book {$timestamp} 2,Jane Smith,PT Penerbit,2023,Non-Fiksi,Buku kedua untuk test CSV,978-5-{$timestamp}-2,3,,https://example2.com,available
CSV;

        $csvFile = tempnam(sys_get_temp_dir(), 'csv_');
        file_put_contents($csvFile, $csvContent);

        $handle = fopen($csvFile, 'r');
        $headers = fgetcsv($handle);
        $headers = array_map('trim', $headers);
        $normalizedHeaders = array_map(function ($h) { return strtolower(str_replace(' ', '_', $h)); }, $headers);

        $imported = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            $row = array_map('trim', $row);
            $rowAssoc = array_combine($normalizedHeaders, $row);

            $data = [
                'title' => $rowAssoc['title'] ?? null,
                'author' => $rowAssoc['author'] ?? null,
                'publisher' => $rowAssoc['publisher'] ?? null,
                'publication_year' => $rowAssoc['publication_year'] ?? null,
                'category' => $rowAssoc['category'] ?? null,
                'summary' => $rowAssoc['summary'] ?? null,
                'isbn' => $rowAssoc['isbn'] ?? null,
                'stock' => $rowAssoc['stock'] ?? 1,
                'cover_url' => $rowAssoc['cover_url'] ?? null,
                'reference_url' => $rowAssoc['reference_url'] ?? null,
                'status' => $rowAssoc['status'] ?? 'available',
            ];

            $validator = Validator::make($data, [
                'title' => ['required', 'string', 'max:255'],
                'author' => ['required', 'string', 'max:255'],
                'isbn' => ['nullable', 'string', 'max:100', 'unique:books,isbn'],
            ]);

            if ($validator->fails()) {
                $errors[] = "Row {$rowNumber}: " . implode('; ', $validator->errors()->all());
                $this->error("❌ Row $rowNumber: " . implode('; ', $validator->errors()->all()));
                continue;
            }

            Book::create($data);
            $imported++;
            $this->line("✅ Row $rowNumber: {$data['title']} imported");
        }

        fclose($handle);
        unlink($csvFile);

        $this->line("\nBuku berhasil di-import: {$imported}");
        if (!empty($errors)) {
            $this->warn("Errors: " . count($errors));
        }

        // Test 2: CSV Member Import
        $this->line("\n\nTEST 2: Import Anggota (CSV)");
        $this->line('---');

        $timestamp = now()->timestamp;
        $memberCsvContent = <<<CSV
member_id,name,email,nim,prodi,role
M-TEST-{$timestamp}-001,Ahmad Satria CSV,ahmad.csv.{$timestamp}@test.com,{$timestamp}001,Teknik Informatika,mahasiswa
M-TEST-{$timestamp}-002,Dr. Budi Rahman CSV,budi.csv.{$timestamp}@test.com,{$timestamp}002,Teknik Elektronika,dosen
CSV;

        $memberCsvFile = tempnam(sys_get_temp_dir(), 'csv_');
        file_put_contents($memberCsvFile, $memberCsvContent);

        $handle = fopen($memberCsvFile, 'r');
        $headers = fgetcsv($handle);
        $headers = array_map('trim', $headers);
        $normalizedHeaders = array_map(function ($h) { return strtolower(str_replace(' ', '_', $h)); }, $headers);

        $importedMembers = 0;
        $errorsMembers = [];
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
                $errorsMembers[] = "Row {$rowNumber}: " . implode('; ', $validator->errors()->all());
                $this->error("❌ Row $rowNumber: " . implode('; ', $validator->errors()->all()));
                continue;
            }

            Member::create($data);
            $importedMembers++;
            $this->line("✅ Row $rowNumber: {$data['name']} ({$data['jenis_anggota']}) imported");
        }

        fclose($handle);
        unlink($memberCsvFile);

        $this->line("\nAnggota berhasil di-import: {$importedMembers}");
        if (!empty($errorsMembers)) {
            $this->warn("Errors: " . count($errorsMembers));
        }

        // Summary
        $this->line("\n\n=== SUMMARY ===");
        $this->info("Books imported: {$imported}");
        $this->info("Members imported: {$importedMembers}");
        $this->info("Total imported: " . ($imported + $importedMembers));

        if (empty($errors) && empty($errorsMembers)) {
            $this->info("\n✅ CSV Import Test PASSED - Semua data berhasil di-import!");
            return 0;
        } else {
            $this->warn("\n⚠️ CSV Import Test PARTIAL - Ada beberapa error.");
            return 1;
        }
    }
}
