<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perpuss;
use App\Models\Peminjaman;
use App\Models\Member;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PerpussController extends Controller
{
    /**
     * Display a listing of perpustakaan books with optional search
     * @return View
     */
    public function index(Request $request): View
    {
        $search = (string) $request->query('q', '');

        $collections = Perpuss::query()
            ->when($search !== '', function ($query) use ($search) {
                $like = "%{$search}%";
                $query->where(function ($inner) use ($like) {
                    $inner->where('title', 'like', $like)
                        ->orWhere('author', 'like', $like)
                        ->orWhere('publisher', 'like', $like)
                        ->orWhere('isbn', 'like', $like)
                        ->orWhere('category', 'like', $like);
                });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.perpus', [
            'books' => $collections,
            'search' => $search,
        ]);
    }

    /**
     * Show form to create new perpustakaan book
     * @return View
     */
    public function create(): View
    {
        return view('admin.inputBuku.inputBukuPerpus');
    }

    /**
     * Store newly created perpustakaan book in storage
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Validate input with custom messages
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255', 'min:3'],
                'author' => ['required', 'string', 'max:255', 'min:3'],
                'publisher' => ['required', 'string', 'max:255', 'min:3'],
                'publication_year' => ['nullable', 'integer', 'between:1900,2100'],
                'category' => ['nullable', 'string', 'max:100'],
                'summary' => ['nullable', 'string', 'max:5000'],
                'isbn' => ['nullable', 'string', 'max:100', 'unique:perpusses,isbn'],
                'stock' => ['nullable', 'integer', 'min:0', 'max:9999'],
                'status' => ['required', 'in:available,unavailable'],
                'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ], [
                'title.required' => 'Judul buku tidak boleh kosong',
                'title.min' => 'Judul buku minimal 3 karakter',
                'author.required' => 'Pengarang tidak boleh kosong',
                'author.min' => 'Nama pengarang minimal 3 karakter',
                'publisher.required' => 'Penerbit tidak boleh kosong',
                'publisher.min' => 'Nama penerbit minimal 3 karakter',

                'isbn.unique' => 'ISBN ini sudah terdaftar dalam sistem',
                'stock.max' => 'Stok tidak boleh lebih dari 9999',
                'cover_image.max' => 'Ukuran gambar terlalu besar (maksimal 2MB)',
                'cover_image.mimes' => 'File sampul harus berformat JPG atau PNG',
                'cover_image.image' => 'File sampul harus berupa gambar',
                'publication_year.between' => 'Tahun publikasi harus antara 1900 dan 2100',
            ]);

            // Set default values
            $validated['stock'] = $validated['stock'] ?? 1;
            $validated['publication_year'] = $validated['publication_year'] ?? (int) now()->format('Y');

            // Create new record
            $book = new Perpuss();
            $book->fill([
                'title' => $validated['title'],
                'author' => $validated['author'],
                'publisher' => $validated['publisher'],
                'publication_year' => $validated['publication_year'],
                'category' => $validated['category'] ?? null,
                'summary' => $validated['summary'] ?? null,
                'isbn' => $validated['isbn'] ?? null,
                'stock' => $validated['stock'],
                'status' => $validated['status'],
            ]);

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                
                if ($file->getSize() > 2097152) { // 2MB = 2097152 bytes
                    return back()
                        ->withInput()
                        ->withErrors(['cover_image' => 'Ukuran file gambar melebihi batas maksimal 2MB']);
                }

                $book->cover_path = $file->store('perpuss/covers', 'public');
            }

            $book->save();

            Log::info('Perpustakaan book created successfully', [
                'book_id' => $book->id,
                'title' => $book->title,
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return redirect()
                ->route('admin.books.library.show')
                ->with('success', "✅ Buku perpustakaan '{$validated['title']}' berhasil ditambahkan. Koleksi fisik telah terupdate.");
        } catch (Exception $e) {
            Log::error('Error creating perpustakaan book', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Show form to edit perpustakaan book
     * @param Perpuss $perpuss
     * @return View
     */
    public function edit(Perpuss $perpuss): View
    {
        return view('admin.inputBuku.editBukuPerpus', compact('perpuss'));
    }

    /**
     * Update perpustakaan book in storage
     * @param Request $request
     * @param Perpuss $perpuss
     * @return RedirectResponse
     */
    public function update(Request $request, Perpuss $perpuss): RedirectResponse
    {
        try {
            // Validate input with custom messages
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255', 'min:3'],
                'author' => ['required', 'string', 'max:255', 'min:3'],
                'publisher' => ['required', 'string', 'max:255', 'min:3'],
                'publication_year' => ['nullable', 'integer', 'between:1900,2100'],
                'category' => ['nullable', 'string', 'max:100'],
                'summary' => ['nullable', 'string', 'max:5000'],
                'isbn' => ['nullable', 'string', 'max:100', 'unique:perpusses,isbn,' . $perpuss->id],
                'stock' => ['nullable', 'integer', 'min:0', 'max:9999'],
                'status' => ['required', 'in:available,unavailable'],
                'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ], [
                'title.required' => 'Judul buku tidak boleh kosong',
                'title.min' => 'Judul buku minimal 3 karakter',
                'author.required' => 'Pengarang tidak boleh kosong',
                'author.min' => 'Nama pengarang minimal 3 karakter',
                'publisher.required' => 'Penerbit tidak boleh kosong',
                'publisher.min' => 'Nama penerbit minimal 3 karakter',
                'isbn.unique' => 'ISBN ini sudah terdaftar dalam sistem',
                'stock.max' => 'Stok tidak boleh lebih dari 9999',
                'cover_image.max' => 'Ukuran gambar terlalu besar (maksimal 2MB)',
                'cover_image.mimes' => 'File sampul harus berformat JPG atau PNG',
                'cover_image.image' => 'File sampul harus berupa gambar',
                'publication_year.between' => 'Tahun publikasi harus antara 1900 dan 2100',
            ]);

            // Update book data
            $perpuss->update([
                'title' => $validated['title'],
                'author' => $validated['author'],
                'publisher' => $validated['publisher'],
                'publication_year' => $validated['publication_year'] ?? (int) now()->format('Y'),
                'category' => $validated['category'] ?? null,
                'summary' => $validated['summary'] ?? null,
                'isbn' => $validated['isbn'] ?? null,
                'stock' => $validated['stock'] ?? 1,
                'status' => $validated['status'],
            ]);

            // Handle cover image update
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                
                if ($file->getSize() > 2097152) { // 2MB = 2097152 bytes
                    return back()
                        ->withInput()
                        ->withErrors(['cover_image' => 'Ukuran file gambar melebihi batas maksimal 2MB']);
                }

                // Delete old cover if exists
                if ($perpuss->cover_path && Storage::disk('public')->exists($perpuss->cover_path)) {
                    Storage::disk('public')->delete($perpuss->cover_path);
                }

                // Upload new cover
                $perpuss->cover_path = $file->store('perpuss/covers', 'public');
                $perpuss->save();
            }

            Log::info('Perpustakaan book updated successfully', [
                'book_id' => $perpuss->id,
                'title' => $perpuss->title,
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return redirect()
                ->route('admin.books.library.show')
                ->with('success', "✅ Buku perpustakaan '{$validated['title']}' berhasil diperbarui.");
        } catch (Exception $e) {
            Log::error('Error updating perpustakaan book', [
                'book_id' => $perpuss->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete perpustakaan book from storage including associated files
     * @param Perpuss $perpuss
     * @return RedirectResponse
     */
    public function destroy(Perpuss $perpuss): RedirectResponse
    {
        try {
            $bookTitle = $perpuss->title;

            // Delete associated files if exist
            if ($perpuss->cover_path && Storage::disk('public')->exists($perpuss->cover_path)) {
                Storage::disk('public')->delete($perpuss->cover_path);
                Log::info('Cover image deleted', ['path' => $perpuss->cover_path]);
            }

            $perpuss->delete();

            Log::info('Perpustakaan book deleted successfully', [
                'book_id' => $perpuss->id,
                'title' => $bookTitle,
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return redirect()
                ->route('admin.books.library.index')
                ->with('success', "✅ Buku perpustakaan '{$bookTitle}' berhasil dihapus dari katalog.");
        } catch (Exception $e) {
            Log::error('Error deleting perpustakaan book', [
                'book_id' => $perpuss->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return back()
                ->withErrors(['general' => 'Terjadi kesalahan saat menghapus buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Display list of all perpustakaan books
     * @return View
     */
    public function show(): View
    {
        $perpusses = Perpuss::orderByDesc('created_at')->get();
        return view('admin.inputBuku.listBuku.ListBukuPerpus', compact('perpusses'));
    }

    /**
     * Show import form for perpustakaan books
     */
    public function importForm(): View
    {
        return view('admin.inputBuku.importPerpus');
    }

    /**
     * Process perpustakaan book CSV import
     */
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
                return redirect()->route('admin.books.library.index')->withErrors(['csv_file' => 'Excel import requires phpoffice/phpspreadsheet. Please run: composer require phpoffice/phpspreadsheet']);
            }

            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                if (empty($rows)) {
                    return redirect()->route('admin.books.library.index')->withErrors(['csv_file' => 'Excel file is empty or malformed']);
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

                    $data = [
                        'title' => $rowAssoc['title'] ?? null,
                        'author' => $rowAssoc['author'] ?? null,
                        'publisher' => $rowAssoc['publisher'] ?? null,
                        'publication_year' => $rowAssoc['publication_year'] ?? null,
                        'category' => $rowAssoc['category'] ?? null,
                        'summary' => $rowAssoc['summary'] ?? null,
                        'isbn' => $rowAssoc['isbn'] ?? null,
                        'stock' => $rowAssoc['stock'] ?? 1,
                        'status' => $rowAssoc['status'] ?? 'available',
                    ];

                    $validator = Validator::make($data, [
                        'title' => ['required', 'string', 'max:255'],
                        'author' => ['required', 'string', 'max:255'],
                        'isbn' => ['nullable', 'string', 'max:100', 'unique:perpusses,isbn'],
                    ]);

                    if ($validator->fails()) {
                        $errors[] = "Row {$rowNumber}: " . implode('; ', $validator->errors()->all());
                        continue;
                    }

                    Perpuss::create($data);
                    $imported++;
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.books.library.index')->withErrors(['csv_file' => 'Error reading Excel file: ' . $e->getMessage()]);
            }
        } else {
            if (($handle = fopen($path, 'r')) !== false) {
                $headers = fgetcsv($handle);
                if ($headers === false) {
                    return redirect()->route('admin.books.library.index')->withErrors(['csv_file' => 'CSV file is empty or malformed']);
                }

                $headers = array_map('trim', $headers);
                $normalizedHeaders = array_map(function ($h) { return strtolower(str_replace(' ', '_', $h)); }, $headers);

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
                        'status' => $rowAssoc['status'] ?? 'available',
                    ];

                    $validator = Validator::make($data, [
                        'title' => ['required', 'string', 'max:255'],
                        'author' => ['required', 'string', 'max:255'],
                        'isbn' => ['nullable', 'string', 'max:100', 'unique:perpusses,isbn'],
                    ]);

                    if ($validator->fails()) {
                        $errors[] = "Row {$rowNumber}: " . implode('; ', $validator->errors()->all());
                        continue;
                    }

                    Perpuss::create($data);
                    $imported++;
                }

                fclose($handle);
            }
        }

        $message = "Imported {$imported} perpustakaan books.";
        if (!empty($errors)) {
            return redirect()->route('admin.books.library.index')->with('warning', $message . ' Some rows skipped: ' . implode(' | ', array_slice($errors, 0, 5)));
        }

        return redirect()->route('admin.books.library.index')->with('success', $message);
    }
}