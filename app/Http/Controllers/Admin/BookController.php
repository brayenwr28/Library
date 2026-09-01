<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;
use League\Csv\Reader;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Display a listing of books with optional search
     * @return View
     */
    public function index(Request $request): View
    {
        $search = (string) $request->query('q', '');

        $books = Book::query()
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
            'books' => $books,
            'search' => $search,
        ]);
    }

    /**
     * Show form to create new book
     * @return View
     */
    public function create(): View
    {
        return view('admin.inputBuku.InputBuku');
    }

    /**
     * Store newly created book in storage
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Pre-process reference_url to prepend scheme if missing
        if ($request->filled('reference_url')) {
            $refUrl = trim((string) $request->input('reference_url'));
            if (!preg_match('~^https?://~i', $refUrl)) {
                $refUrl = 'https://' . $refUrl;
                $request->merge(['reference_url' => $refUrl]);
            }
        }

        try {
            // Validate input with custom messages
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255', 'min:3'],
                'author' => ['required', 'string', 'max:255', 'min:3'],
                'publisher' => ['required', 'string', 'max:255', 'min:3'],
                'publication_year' => ['nullable', 'integer', 'between:1900,2100'],
                'category' => ['nullable', 'string', 'max:100'],
                'summary' => ['nullable', 'string', 'max:5000'],
                'isbn' => ['nullable', 'string', 'max:100', 'unique:books,isbn'],
                'stock' => ['nullable', 'integer', 'min:0', 'max:9999'],
                'cover_url' => ['nullable', 'string', 'max:500'],
                'cover_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
                'reference_url' => ['nullable', 'url', 'max:500'],
                'status' => ['required', 'in:available,unavailable'],
                'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:102400'],
            ], [
                'title.required' => 'Judul buku tidak boleh kosong',
                'title.min' => 'Judul buku minimal 3 karakter',
                'author.required' => 'Penulis tidak boleh kosong',
                'author.min' => 'Nama penulis minimal 3 karakter',
                'publisher.required' => 'Penerbit tidak boleh kosong',
                'isbn.unique' => 'ISBN ini sudah terdaftar dalam sistem',
                'cover_image.image' => 'File sampul harus berupa gambar (JPG, PNG, WEBP)',
                'cover_image.max' => 'Ukuran file sampul maksimal 5MB',
                'reference_url.url' => 'Format Link Referensi tidak valid (contoh: https://example.com)',
                'pdf_file.max' => 'Ukuran file PDF terlalu besar (maksimal 100MB)',
                'pdf_file.mimes' => 'File harus berformat PDF',
                'publication_year.between' => 'Tahun publikasi harus antara 1900 dan 2100',
            ]);

            // Set default values
            $validated['stock'] = $validated['stock'] ?? 1;
            $validated['publication_year'] = $validated['publication_year'] ?? (int) now()->format('Y');

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $coverFile = $request->file('cover_image');
                if ($coverFile->isValid()) {
                    $validated['cover_url'] = $coverFile->store('books/covers', 'public');
                }
            }

            // Handle PDF file upload (100MB limit = 104857600 bytes)
            if ($request->hasFile('pdf_file')) {
                $file = $request->file('pdf_file');
                
                if ($file->getSize() > 104857600) {
                    return back()
                        ->withInput()
                        ->withErrors(['pdf_file' => 'Ukuran file PDF melebihi batas maksimal 100MB']);
                }

                $validated['pdf_path'] = $file->store('books/pdfs', 'public');
            }

            // Remove cover_image from array before create
            unset($validated['cover_image']);

            // Create book record
            $book = Book::create($validated);

            // Log the action for audit trail
            Log::info('Book created successfully', [
                'book_id' => $book->id,
                'title' => $book->title,
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return redirect()
                ->route('admin.books.show')
                ->with('success', "✅ Buku '{$validated['title']}' berhasil ditambahkan ke katalog. Buku dapat langsung diakses oleh pengguna.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Error creating book', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan saat menyimpan buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Show form to edit existing book
     * @param Book $book
     * @return View
     */
    public function edit(Book $book): View
    {
        return view('admin.inputBuku.EditBuku', compact('book'));
    }

    /**
     * Update existing book in storage
     * @param Request $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        // Pre-process reference_url to prepend scheme if missing
        if ($request->filled('reference_url')) {
            $refUrl = trim((string) $request->input('reference_url'));
            if (!preg_match('~^https?://~i', $refUrl)) {
                $refUrl = 'https://' . $refUrl;
                $request->merge(['reference_url' => $refUrl]);
            }
        }

        try {
            // Validate input with unique rule excluding current book
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255', 'min:3'],
                'author' => ['required', 'string', 'max:255', 'min:3'],
                'publisher' => ['required', 'string', 'max:255', 'min:3'],
                'publication_year' => ['nullable', 'integer', 'between:1900,2100'],
                'category' => ['nullable', 'string', 'max:100'],
                'summary' => ['nullable', 'string', 'max:5000'],
                'isbn' => ['nullable', 'string', 'max:100', "unique:books,isbn,{$book->id}"],
                'stock' => ['nullable', 'integer', 'min:0', 'max:9999'],
                'cover_url' => ['nullable', 'string', 'max:500'],
                'cover_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
                'reference_url' => ['nullable', 'url', 'max:500'],
                'status' => ['required', 'in:available,unavailable'],
                'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:102400'],
            ], [
                'title.required' => 'Judul buku tidak boleh kosong',
                'title.min' => 'Judul buku minimal 3 karakter',
                'author.required' => 'Penulis tidak boleh kosong',
                'author.min' => 'Nama penulis minimal 3 karakter',
                'publisher.required' => 'Penerbit tidak boleh kosong',
                'isbn.unique' => 'ISBN ini sudah terdaftar (ID: ' . $book->id . ')',
                'cover_image.image' => 'File sampul harus berupa gambar (JPG, PNG, WEBP)',
                'cover_image.max' => 'Ukuran file sampul maksimal 5MB',
                'reference_url.url' => 'Format Link Referensi tidak valid (contoh: https://example.com)',
                'pdf_file.max' => 'Ukuran file PDF terlalu besar (maksimal 100MB)',
                'pdf_file.mimes' => 'File harus berformat PDF',
            ]);

            // Set default values
            $validated['stock'] = $validated['stock'] ?? 1;
            $validated['publication_year'] = $validated['publication_year'] ?? (int) now()->format('Y');

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $coverFile = $request->file('cover_image');
                if ($coverFile->isValid()) {
                    // Get raw cover_url attribute without Accessor transformations
                    $rawCover = $book->getRawOriginal('cover_url');
                    if ($rawCover && !str_starts_with($rawCover, 'http://') && !str_starts_with($rawCover, 'https://')) {
                        if (Storage::disk('public')->exists($rawCover)) {
                            Storage::disk('public')->delete($rawCover);
                        }
                    }
                    $validated['cover_url'] = $coverFile->store('books/covers', 'public');
                }
            }

            // Store old PDF path for cleanup
            $oldPdfPath = $book->pdf_path;

            // Handle PDF file upload
            if ($request->hasFile('pdf_file')) {
                $file = $request->file('pdf_file');
                
                if ($file->getSize() > 104857600) {
                    return back()
                        ->withInput()
                        ->withErrors(['pdf_file' => 'Ukuran file PDF melebihi batas maksimal 100MB']);
                }

                // Delete old PDF if exists
                if ($oldPdfPath && Storage::disk('public')->exists($oldPdfPath)) {
                    Storage::disk('public')->delete($oldPdfPath);
                    Log::info('Old PDF deleted', ['path' => $oldPdfPath]);
                }

                $validated['pdf_path'] = $file->store('books/pdfs', 'public');
            }

            // Remove cover_image from array before update
            unset($validated['cover_image']);

            // Update book record
            $book->update($validated);

            Log::info('Book updated successfully', [
                'book_id' => $book->id,
                'title' => $book->title,
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return redirect()
                ->route('admin.books.show')
                ->with('success', "✅ Data buku '{$validated['title']}' berhasil diperbarui.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Error updating book', [
                'book_id' => $book->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan saat memperbarui buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete book from storage including associated files
     * @param Book $book
     * @return RedirectResponse
     */
    public function destroy(Book $book): RedirectResponse
    {
        try {
            $bookTitle = $book->title;

            // Delete associated PDF file if exists
            if ($book->pdf_path && Storage::disk('public')->exists($book->pdf_path)) {
                Storage::disk('public')->delete($book->pdf_path);
                Log::info('PDF file deleted', ['path' => $book->pdf_path]);
            }

            // Delete book record
            $book->delete();

            Log::info('Book deleted successfully', [
                'book_id' => $book->id,
                'title' => $bookTitle,
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return redirect()
                ->route('admin.books.show')
                ->with('success', "✅ Buku '{$bookTitle}' berhasil dihapus dari katalog.");
        } catch (Exception $e) {
            Log::error('Error deleting book', [
                'book_id' => $book->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return back()
                ->withErrors(['general' => 'Terjadi kesalahan saat menghapus buku. Silakan coba lagi.']);
        }
    }

    /**
     * Display list of all books
     * @return View
     */
    public function show(): View
    {
        $books = Book::orderByDesc('created_at')->get();
        return view('admin.inputBuku.listBuku.ListBukuDigital', compact('books'));
    }

    /**
     * Show import form for books
     */
    public function importForm(): View
    {
        return view('admin.inputBuku.import');
    }

    /**
     * Process book CSV import
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
                return redirect()->route('admin.books.show')->withErrors(['csv_file' => 'Excel import requires phpoffice/phpspreadsheet. Please run: composer require phpoffice/phpspreadsheet']);
            }

            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                if (empty($rows)) {
                    return redirect()->route('admin.books.show')->withErrors(['csv_file' => 'Excel file is empty or malformed']);
                }

                // first row = headers
                $rawHeaders = array_values($rows[1]);
                $headers = array_map(function ($h) { return strtolower(str_replace(' ', '_', trim((string)$h))); }, $rawHeaders);

                $rowNumber = 1;
                foreach ($rows as $idx => $row) {
                    if ($idx === 1) continue; // skip header
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
                        continue;
                    }

                    Book::create($data);
                    $imported++;
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.books.show')->withErrors(['csv_file' => 'Error reading Excel file: ' . $e->getMessage()]);
            }
        } else {
            if (($handle = fopen($path, 'r')) !== false) {
                $headers = fgetcsv($handle);
                if ($headers === false) {
                    return redirect()->route('admin.books.show')->withErrors(['csv_file' => 'CSV file is empty or malformed']);
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
                        continue;
                    }

                    Book::create($data);
                    $imported++;
                }

                fclose($handle);
            }
        }

        $message = "Imported {$imported} books.";
        if (!empty($errors)) {
            return redirect()->route('admin.books.show')->with('warning', $message . ' Some rows skipped: ' . implode(' | ', array_slice($errors, 0, 5)));
        }

        return redirect()->route('admin.books.show')->with('success', $message);
    }
}
