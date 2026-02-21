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
                'cover_url' => ['nullable', 'url', 'max:255'],
                'status' => ['required', 'in:available,unavailable'],
                'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            ], [
                'title.required' => 'Judul buku tidak boleh kosong',
                'title.min' => 'Judul buku minimal 3 karakter',
                'author.required' => 'Penulis tidak boleh kosong',
                'author.min' => 'Nama penulis minimal 3 karakter',
                'publisher.required' => 'Penerbit tidak boleh kosong',
                'isbn.unique' => 'ISBN ini sudah terdaftar dalam sistem',
                'pdf_file.max' => 'Ukuran file PDF terlalu besar (maksimal 20MB)',
                'pdf_file.mimes' => 'File harus berformat PDF',
                'publication_year.between' => 'Tahun publikasi harus antara 1900 dan 2100',
            ]);

            // Set default values
            $validated['stock'] = $validated['stock'] ?? 1;
            $validated['publication_year'] = $validated['publication_year'] ?? (int) now()->format('Y');

            // Handle PDF file upload
            if ($request->hasFile('pdf_file')) {
                $file = $request->file('pdf_file');
                
                // Validate file size in bytes (20MB = 20971520 bytes)
                if ($file->getSize() > 20971520) {
                    return back()
                        ->withInput()
                        ->withErrors(['pdf_file' => 'Ukuran file PDF melebihi batas maksimal 20MB']);
                }

                $validated['pdf_path'] = $file->store('books/pdfs', 'public');
            }

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
        } catch (Exception $e) {
            Log::error('Error creating book', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan saat menyimpan buku. Silakan coba lagi.']);
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
        try {
            // Validate input with unique rule excluding current book
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255', 'min:3'],
                'author' => ['required', 'string', 'max:255', 'min:3'],
                'publisher' => ['required', 'string', 'max:255', 'min:3'],
                'publication_year' => ['nullable', 'integer', 'between:1900,2100'],
                'category' => ['nullable', 'string', 'max:100'],
                'summary' => ['nullable', 'string', 'max:5000'],
                'isbn' => ['nullable', 'string', 'max:30', "unique:books,isbn,{$book->id}", 'regex:/^[0-9\-]{10,}$/'],
                'stock' => ['nullable', 'integer', 'min:0', 'max:9999'],
                'cover_url' => ['nullable', 'url', 'max:255'],
                'status' => ['required', 'in:available,unavailable'],
                'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            ], [
                'title.required' => 'Judul buku tidak boleh kosong',
                'title.min' => 'Judul buku minimal 3 karakter',
                'author.required' => 'Penulis tidak boleh kosong',
                'author.min' => 'Nama penulis minimal 3 karakter',
                'publisher.required' => 'Penerbit tidak boleh kosong',
                'isbn.regex' => 'Format ISBN tidak valid',
                'isbn.unique' => 'ISBN ini sudah terdaftar (ID: ' . $book->id . ')',
                'pdf_file.max' => 'Ukuran file PDF terlalu besar (maksimal 20MB)',
                'pdf_file.mimes' => 'File harus berformat PDF',
            ]);

            // Set default values
            $validated['stock'] = $validated['stock'] ?? 1;
            $validated['publication_year'] = $validated['publication_year'] ?? (int) now()->format('Y');

            // Store old PDF path for cleanup
            $oldPdfPath = $book->pdf_path;

            // Handle PDF file upload
            if ($request->hasFile('pdf_file')) {
                $file = $request->file('pdf_file');
                
                if ($file->getSize() > 20971520) {
                    return back()
                        ->withInput()
                        ->withErrors(['pdf_file' => 'Ukuran file PDF melebihi batas maksimal 20MB']);
                }

                // Delete old PDF if exists
                if ($oldPdfPath && Storage::disk('public')->exists($oldPdfPath)) {
                    Storage::disk('public')->delete($oldPdfPath);
                    Log::info('Old PDF deleted', ['path' => $oldPdfPath]);
                }

                $validated['pdf_path'] = $file->store('books/pdfs', 'public');
            }

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
        } catch (Exception $e) {
            Log::error('Error updating book', [
                'book_id' => $book->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'timestamp' => now(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan saat memperbarui buku. Silakan coba lagi.']);
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
}
