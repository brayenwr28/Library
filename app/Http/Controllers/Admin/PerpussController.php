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
                ->route('admin.books.library.index')
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
}