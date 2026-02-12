<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Perpuss;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PerpussController extends Controller
{
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

    public function create(): View
    {
        return view('admin.inputBuku.inputBukuPerpus');
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
            'isbn' => ['nullable', 'string', 'max:30', 'unique:perpusses,isbn'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:available,unavailable'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $record = new Perpuss();
        $record->fill([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'publisher' => $validated['publisher'],
            'publication_year' => $validated['publication_year'] ?? (int) now()->format('Y'),
            'category' => $validated['category'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'isbn' => $validated['isbn'] ?? null,
            'stock' => $validated['stock'] ?? 0,
            'status' => $validated['status'],
        ]);

        if ($request->hasFile('cover_image')) {
            $record->cover_path = $request->file('cover_image')->store('perpuss/covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $record->pdf_path = $request->file('pdf_file')->store('perpuss/pdfs', 'public');
        }

        $record->save();

        return redirect()
            ->route('admin.books.library.create')
            ->with('success', 'Buku perpustakaan berhasil ditambahkan.');
    }

    public function destroy(Perpuss $perpuss): RedirectResponse
    {
        if ($perpuss->cover_path) {
            Storage::disk('public')->delete($perpuss->cover_path);
        }

        if ($perpuss->pdf_path) {
            Storage::disk('public')->delete($perpuss->pdf_path);
        }

        $perpuss->delete();

        return redirect()
            ->route('admin.books.library.index')
            ->with('success', 'Buku perpustakaan berhasil dihapus.');
    }
     public function show()
    {
         $perpusses = Perpuss::all();
        return view('admin.inputBuku.listBuku.ListBukuPerpus', compact('perpusses'));
    }
   
}