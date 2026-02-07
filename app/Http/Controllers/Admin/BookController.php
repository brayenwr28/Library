<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
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

    public function create(): View
    {
        return view('admin.inputBuku.InputBuku');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'between:1900,2100'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'isbn' => ['nullable', 'string', 'max:30', 'unique:books,isbn'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'cover_url' => ['nullable', 'url'],
            'status' => ['required', 'in:available,unavailable'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
        ]);

        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['publication_year'] = $validated['publication_year'] ?? (int) now()->format('Y');

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_path'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        Book::create($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan ke katalog.');
    }
}
