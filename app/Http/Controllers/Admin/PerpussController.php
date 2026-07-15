<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perpuss;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PerpussController extends Controller
{
    /**
     * Display a listing of perpustakaan books with optional search
     */
    public function index(Request $request): View
    {
        $search = (string) $request->query('q', '');

        $query = Perpuss::query()
            ->when($search !== '', function ($query) use ($search) {
                $like = "%{$search}%";
                $query->where(function ($inner) use ($like) {
                    $inner->where('title', 'like', $like)
                        ->orWhere('author', 'like', $like)
                        ->orWhere('publisher', 'like', $like)
                        ->orWhere('isbn', 'like', $like)
                        ->orWhere('category', 'like', $like)
                        ->orWhere('klasifikasi', 'like', $like)
                        ->orWhere('edisi', 'like', $like)
                        ->orWhere('registration_number', 'like', $like);
                });
            });

        $totalCount = $query->count();
        $availableCount = (clone $query)->where('status', 'available')->count();
        $unavailableCount = (clone $query)->where('status', 'unavailable')->count();
        $totalStock = $query->sum('stock');

        $collections = $query->orderByDesc('created_at')
            ->paginate(30)
            ->withQueryString();

        return view('dashboard.perpus', [
            'books' => $collections,
            'search' => $search,
            'totalCount' => $totalCount,
            'availableCount' => $availableCount,
            'unavailableCount' => $unavailableCount,
            'totalStock' => $totalStock,
        ]);
    }

    /**
     * Show form to create new perpustakaan book
     */
    public function create(): View
    {
        return view('admin.inputBuku.inputBukuPerpus');
    }

    /**
     * Store newly created perpustakaan book in storage
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'registration_number' => ['nullable', 'string', 'max:100'],
                'title'               => ['required', 'string', 'max:255', 'min:3'],
                'author'              => ['required', 'string', 'max:255', 'min:3'],
                'isbn'                => ['nullable', 'string', 'max:100', 'unique:perpusses,isbn'],
                'publisher'           => ['required', 'string', 'max:255', 'min:3'],
                'publication_year'    => ['nullable', 'integer', 'between:1900,2100'],
                'klasifikasi'         => ['nullable', 'string', 'max:100'],
                'edisi'               => ['nullable', 'string', 'max:100'],
                'stock'               => ['nullable', 'integer', 'min:0', 'max:9999'],
                'category'            => ['nullable', 'string', 'max:100'],
                'cover_image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ], [
                'title.required'             => 'Judul buku tidak boleh kosong',
                'title.min'                  => 'Judul buku minimal 3 karakter',
                'author.required'            => 'Penulis tidak boleh kosong',
                'author.min'                 => 'Nama penulis minimal 3 karakter',
                'publisher.required'         => 'Penerbit tidak boleh kosong',
                'publisher.min'              => 'Nama penerbit minimal 3 karakter',
                'isbn.unique'                => 'ISBN ini sudah terdaftar dalam sistem',
                'stock.max'                  => 'Jumlah tidak boleh lebih dari 9999',
                'cover_image.max'            => 'Ukuran gambar terlalu besar (maksimal 2MB)',
                'cover_image.mimes'          => 'File sampul harus berformat JPG atau PNG',
                'cover_image.image'          => 'File sampul harus berupa gambar',
                'publication_year.between'   => 'Tahun harus antara 1900 dan 2100',
            ]);

            $validated['stock'] = $validated['stock'] ?? 1;
            $validated['publication_year'] = $validated['publication_year'] ?? (int) now()->format('Y');

            $book = new Perpuss();
            $book->fill([
                'registration_number' => $validated['registration_number'] ?? null,
                'title'               => $validated['title'],
                'author'              => $validated['author'],
                'isbn'                => $validated['isbn'] ?? null,
                'publisher'           => $validated['publisher'],
                'publication_year'    => $validated['publication_year'],
                'klasifikasi'         => $validated['klasifikasi'] ?? null,
                'edisi'               => $validated['edisi'] ?? null,
                'stock'               => $validated['stock'],
                'category'            => $validated['category'] ?? null,
                'status'              => 'available',
            ]);

            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                if ($file->getSize() > 2097152) {
                    return back()->withInput()->withErrors(['cover_image' => 'Ukuran file melebihi 2MB']);
                }
                $book->cover_path = $file->store('perpuss/covers', 'public');
            }

            $book->save();

            Log::info('Perpuss book created', ['book_id' => $book->id, 'title' => $book->title]);

            return redirect()
                ->route('admin.books.library.show')
                ->with('success', "✅ Buku '{$validated['title']}' berhasil ditambahkan ke katalog.");
        } catch (Exception $e) {
            Log::error('Error creating perpuss book', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Show form to edit perpustakaan book
     */
    public function edit(Perpuss $perpuss): View
    {
        return view('admin.inputBuku.editBukuPerpus', compact('perpuss'));
    }

    /**
     * Update perpustakaan book in storage
     */
    public function update(Request $request, Perpuss $perpuss): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'registration_number' => ['nullable', 'string', 'max:100'],
                'title'               => ['required', 'string', 'max:255', 'min:3'],
                'author'              => ['required', 'string', 'max:255', 'min:3'],
                'isbn'                => ['nullable', 'string', 'max:100', 'unique:perpusses,isbn,' . $perpuss->id],
                'publisher'           => ['required', 'string', 'max:255', 'min:3'],
                'publication_year'    => ['nullable', 'integer', 'between:1900,2100'],
                'klasifikasi'         => ['nullable', 'string', 'max:100'],
                'edisi'               => ['nullable', 'string', 'max:100'],
                'stock'               => ['nullable', 'integer', 'min:0', 'max:9999'],
                'category'            => ['nullable', 'string', 'max:100'],
                'cover_image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ], [
                'title.required'           => 'Judul buku tidak boleh kosong',
                'title.min'                => 'Judul buku minimal 3 karakter',
                'author.required'          => 'Penulis tidak boleh kosong',
                'publisher.required'       => 'Penerbit tidak boleh kosong',
                'isbn.unique'              => 'ISBN ini sudah terdaftar dalam sistem',
                'publication_year.between' => 'Tahun harus antara 1900 dan 2100',
            ]);

            $perpuss->update([
                'registration_number' => $validated['registration_number'] ?? null,
                'title'               => $validated['title'],
                'author'              => $validated['author'],
                'isbn'                => $validated['isbn'] ?? null,
                'publisher'           => $validated['publisher'],
                'publication_year'    => $validated['publication_year'] ?? (int) now()->format('Y'),
                'klasifikasi'         => $validated['klasifikasi'] ?? null,
                'edisi'               => $validated['edisi'] ?? null,
                'stock'               => $validated['stock'] ?? 1,
                'category'            => $validated['category'] ?? null,
                'status'              => 'available',
            ]);

            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                if ($file->getSize() > 2097152) {
                    return back()->withInput()->withErrors(['cover_image' => 'Ukuran file melebihi 2MB']);
                }
                if ($perpuss->cover_path && Storage::disk('public')->exists($perpuss->cover_path)) {
                    Storage::disk('public')->delete($perpuss->cover_path);
                }
                $perpuss->cover_path = $file->store('perpuss/covers', 'public');
                $perpuss->save();
            }

            Log::info('Perpuss book updated', ['book_id' => $perpuss->id, 'title' => $perpuss->title]);

            return redirect()
                ->route('admin.books.library.show')
                ->with('success', "✅ Buku '{$validated['title']}' berhasil diperbarui.");
        } catch (Exception $e) {
            Log::error('Error updating perpuss book', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete perpustakaan book
     */
    public function destroy(Perpuss $perpuss): RedirectResponse
    {
        try {
            $bookTitle = $perpuss->title;
            if ($perpuss->cover_path && Storage::disk('public')->exists($perpuss->cover_path)) {
                Storage::disk('public')->delete($perpuss->cover_path);
            }
            $perpuss->delete();
            Log::info('Perpuss book deleted', ['title' => $bookTitle]);
            return redirect()->route('admin.books.library.show')
                ->with('success', "✅ Buku '{$bookTitle}' berhasil dihapus dari katalog.");
        } catch (Exception $e) {
            Log::error('Error deleting perpuss book', ['error' => $e->getMessage()]);
            return back()->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display paginated list of all perpustakaan books
     */
    public function show(Request $request): View
    {
        $search = (string) $request->query('q', '');

        $perpusses = Perpuss::query()
            ->when($search !== '', function ($query) use ($search) {
                $like = "%{$search}%";
                $query->where(function ($inner) use ($like) {
                    $inner->where('title', 'like', $like)
                        ->orWhere('author', 'like', $like)
                        ->orWhere('publisher', 'like', $like)
                        ->orWhere('isbn', 'like', $like)
                        ->orWhere('registration_number', 'like', $like)
                        ->orWhere('klasifikasi', 'like', $like)
                        ->orWhere('edisi', 'like', $like)
                        ->orWhere('category', 'like', $like);
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.inputBuku.listBuku.ListBukuPerpus', compact('perpusses', 'search'));
    }

    /**
     * Show import form for perpustakaan books
     */
    public function importForm(): View
    {
        return view('admin.inputBuku.importPerpus');
    }

    /**
     * Download Excel template for book import
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import Buku');

        $headers = [
            'A' => 'no',
            'B' => 'registration_number',
            'C' => 'title',
            'D' => 'author',
            'E' => 'isbn',
            'F' => 'publisher',
            'G' => 'publication_year',
            'H' => 'klasifikasi',
            'I' => 'edisi',
            'J' => 'category',
            'K' => 'stock',
        ];

        foreach ($headers as $col => $label) {
            $sheet->setCellValue($col . '1', $label);
        }

        // Header styling
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2563EB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFB8C4E3']]],
        ];
        $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(22);

        // Sample data rows
        $samples = [
            [1, '1.000176', 'Mengupas Tuntas Formula Excel', 'Adi Kusrianto', '979-20-1828-X', 'ELEX MEDIA', 2000, '5.3', 'Edisi 1', 'APLIKASI', 1],
            [2, '1.020176', 'Panduan Windows XP', 'Andry Syahputra', '979-533-793-9', 'ANDI YOGYAKARTA', 2002, '5.3', 'Edisi 1', 'APLIKASI', 1],
        ];

        foreach ($samples as $i => $row) {
            $rowNum = $i + 2;
            foreach (array_values($headers) as $j => $header) {
                $col = chr(65 + $j);
                $sheet->setCellValue($col . $rowNum, $row[$j]);
            }
            $rowStyle = $i % 2 === 0
                ? ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF8FAFF']]]
                : ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEFF6FF']]];
            $sheet->getStyle('A' . $rowNum . ':K' . $rowNum)->applyFromArray($rowStyle);
        }

        // Column widths
        $widths = ['A' => 8, 'B' => 18, 'C' => 40, 'D' => 25, 'E' => 22, 'F' => 25, 'G' => 12, 'H' => 16, 'I' => 16, 'J' => 22, 'K' => 12];
        foreach ($widths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // Notes row
        $noteRow = count($samples) + 3;
        $sheet->setCellValue('A' . $noteRow, '⚠ Catatan: Kolom title dan author wajib diisi. Hapus baris contoh sebelum import.');
        $sheet->mergeCells('A' . $noteRow . ':K' . $noteRow);
        $sheet->getStyle('A' . $noteRow)->applyFromArray([
            'font' => ['italic' => true, 'color' => ['argb' => 'FF92400E'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFEF3C7']],
        ]);

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_import_buku_perpustakaan.xlsx';

        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export all books to Excel
     */
    public function exportExcel(Request $request)
    {
        $search = (string) $request->query('q', '');

        $books = Perpuss::query()
            ->when($search !== '', function ($query) use ($search) {
                $like = "%{$search}%";
                $query->where(function ($inner) use ($like) {
                    $inner->where('title', 'like', $like)
                        ->orWhere('author', 'like', $like)
                        ->orWhere('publisher', 'like', $like)
                        ->orWhere('isbn', 'like', $like)
                        ->orWhere('category', 'like', $like)
                        ->orWhere('klasifikasi', 'like', $like)
                        ->orWhere('edisi', 'like', $like)
                        ->orWhere('registration_number', 'like', $like);
                });
            })
            ->orderByDesc('created_at')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Buku Perpustakaan');

        // Title row
        $sheet->setCellValue('A1', 'DAFTAR BUKU PERPUSTAKAAN');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF1E3A8A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDBEAFE']],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->setCellValue('A2', 'Tanggal Export: ' . now()->format('d/m/Y H:i'));
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Headers: No, No. Registrasi, Judul Buku, Penulis/Pengarang, ISBN, Penerbit, Tahun, Klasifikasi, Edisi, Subjek/Kategori, Jumlah
        $headers = ['No', 'No. Registrasi', 'Judul Buku', 'Penulis / Pengarang', 'ISBN', 'Penerbit', 'Tahun', 'Klasifikasi', 'Edisi', 'Subjek / Kategori', 'Jumlah'];
        foreach ($headers as $i => $header) {
            $sheet->setCellValue(chr(65 + $i) . '4', $header);
        }

        $sheet->getStyle('A4:K4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1D4ED8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getRowDimension(4)->setRowHeight(20);

        // Data rows
        foreach ($books as $i => $book) {
            $row = $i + 5;
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $book->registration_number ?? '');
            $sheet->setCellValue('C' . $row, $book->title);
            $sheet->setCellValue('D' . $row, $book->author);
            $sheet->setCellValue('E' . $row, $book->isbn ?? '');
            $sheet->setCellValue('F' . $row, $book->publisher ?? '');
            $sheet->setCellValue('G' . $row, $book->publication_year ?? '');
            $sheet->setCellValue('H' . $row, $book->klasifikasi ?? '');
            $sheet->setCellValue('I' . $row, $book->edisi ?? '');
            $sheet->setCellValue('J' . $row, $book->category ?? '');
            $sheet->setCellValue('K' . $row, $book->stock ?? 0);

            $bgColor = $i % 2 === 0 ? 'FFFAFAFA' : 'FFF0F7FF';
            $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_HAIR, 'color' => ['argb' => 'FFE2E8F0']]],
            ]);
        }

        // Column widths
        $widths = ['A' => 6, 'B' => 18, 'C' => 40, 'D' => 25, 'E' => 22, 'F' => 25, 'G' => 10, 'H' => 20, 'I' => 16, 'J' => 22, 'K' => 10];
        foreach ($widths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        $sheet->getStyle('A5:A' . (count($books) + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G5:G' . (count($books) + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K5:K' . (count($books) + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $writer = new Xlsx($spreadsheet);
        $filename = 'export_buku_perpustakaan_' . now()->format('Ymd_His') . '.xlsx';

        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Preview imported Excel data (stores in cache for reliability, redirects back with preview)
     */
    public function importPreview(Request $request): RedirectResponse
    {
        $request->validate([
            'excel_file' => ['required', 'file', 'max:10240'],
        ]);

        $extension = strtolower($request->file('excel_file')->getClientOriginalExtension());
        $allowedExtensions = ['csv', 'txt', 'xlsx', 'xls'];

        if (!in_array($extension, $allowedExtensions)) {
            return redirect()->back()->withErrors([
                'excel_file' => 'Format file tidak didukung. Gunakan: .xlsx, .xls, atau .csv'
            ]);
        }

        $path = $request->file('excel_file')->getRealPath();
        $previewData = [];

        try {
            if (in_array($extension, ['xlsx', 'xls'])) {
                try {
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
                    $reader->setReadDataOnly(true);
                    $spreadsheet = $reader->load($path);
                } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                    try {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
                        $spreadsheet = $reader->load($path);
                    } catch (\Exception $e2) {
                        return redirect()->back()->withErrors([
                            'excel_file' => 'File XLS tidak dapat dibaca. Coba simpan ulang sebagai format .xlsx dari Microsoft Excel, lalu upload kembali.'
                        ]);
                    }
                }

                $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                if (empty($rows)) {
                    return redirect()->back()->withErrors(['excel_file' => 'File Excel kosong atau tidak valid']);
                }

                $rawHeaders = array_values($rows[array_key_first($rows)]);
                $headers = $this->mapHeaders($rawHeaders);

                $first = true;
                foreach ($rows as $row) {
                    if ($first) {
                        $first = false;
                        continue;
                    }
                    $values = array_map(fn($v) => is_scalar($v) ? trim((string) $v) : '', array_values($row));
                    if (count($values) < count($headers)) {
                        $values = array_pad($values, count($headers), '');
                    }
                    $assoc = array_combine($headers, array_slice($values, 0, count($headers)));
                    if (empty(trim($assoc['title'] ?? ''))) {
                        continue;
                    }
                    $previewData[] = $this->normalizeRow($assoc);
                }
            } else {
                if (($handle = fopen($path, 'r')) !== false) {
                    $rawHeaders = fgetcsv($handle);
                    if ($rawHeaders === false) {
                        return redirect()->back()->withErrors(['excel_file' => 'File CSV kosong atau tidak valid']);
                    }
                    $headers = $this->mapHeaders($rawHeaders);

                    while (($row = fgetcsv($handle)) !== false) {
                        $row = array_map('trim', $row);
                        if (count($row) < count($headers)) {
                            $row = array_pad($row, count($headers), '');
                        }
                        $assoc = array_combine($headers, array_slice($row, 0, count($headers)));
                        if (empty($assoc['title'] ?? '')) {
                            continue;
                        }
                        $previewData[] = $this->normalizeRow($assoc);
                    }
                    fclose($handle);
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['excel_file' => 'Gagal membaca file: ' . $e->getMessage()]);
        }

        if (empty($previewData)) {
            return redirect()->back()->withErrors(['excel_file' => 'Tidak ada data valid yang ditemukan dalam file.']);
        }

        $previewKey = 'preview_' . uniqid();
        
        // Simpan data di cache berdurasi 30 menit (jauh lebih aman dibanding cookie session untuk file besar)
        Cache::put($previewKey, $previewData, now()->addMinutes(30));

        session([
            'preview_key' => $previewKey,
        ]);

        return redirect()->route('admin.books.library.import.form')
            ->with('preview_data', $previewData)
            ->with('preview_key', $previewKey);
    }

    /**
     * Confirm and save previewed import data to database
     */
    public function importConfirm(Request $request): RedirectResponse
    {
        $previewKey = $request->input('preview_key') ?? session('preview_key');
        
        // Coba ambil dari Cache terlebih dahulu
        $previewData = Cache::get($previewKey);
        
        // Fallback ke session jika di Cache tidak ada
        if (empty($previewData)) {
            $previewData = session('preview_data', []);
        }

        if (empty($previewData)) {
            return redirect()->route('admin.books.library.import.form')
                ->withErrors(['general' => 'Sesi preview telah habis. Silakan upload ulang.']);
        }

        $imported = 0;
        $skipped = 0;

        foreach ($previewData as $row) {
            $validator = Validator::make($row, [
                'title'  => ['required', 'string', 'max:255'],
                'author' => ['required', 'string', 'max:255'],
                'isbn'   => ['nullable', 'string', 'max:100'],
            ]);

            if ($validator->fails()) {
                $skipped++;
                continue;
            }

            $existingBook = null;
            if (!empty($row['isbn'])) {
                $existingBook = Perpuss::where('isbn', $row['isbn'])->first();
            } else {
                $existingBook = Perpuss::where('title', $row['title'])
                                       ->where('author', $row['author'])
                                       ->first();
            }

            if ($existingBook) {
                $existingBook->stock += (int)($row['stock'] ?? 1);
                $existingBook->save();
                $imported++;
                continue;
            }

            Perpuss::create($row);
            $imported++;
        }

        // Hapus cache & session setelah selesai
        Cache::forget($previewKey);
        session()->forget(['preview_data', 'preview_key']);

        $message = "✅ Berhasil mengimpor {$imported} buku ke katalog.";
        if ($skipped > 0) {
            return redirect()->route('admin.books.library.show')
                ->with('warning', $message . " {$skipped} baris dilewati (duplikat ISBN atau data tidak valid).");
        }

        return redirect()->route('admin.books.library.show')->with('success', $message);
    }

    /**
     * Process perpustakaan book CSV/Excel import (legacy direct import)
     */
    public function importProcess(Request $request): RedirectResponse
    {
        return $this->importPreview($request);
    }

    /**
     * Map varying column headers to database column keys
     */
    private function mapHeaders(array $rawHeaders): array
    {
        $mapped = [];
        foreach ($rawHeaders as $header) {
            $h = strtolower(str_replace([' ', '-', '.', '/'], '_', trim((string)$header)));
            $h = preg_replace('/_+/', '_', $h); // remove multiple underscores
            $h = trim($h, '_');

            if (in_array($h, ['no', 'no_'])) {
                $mapped[] = 'no';
            } elseif (in_array($h, ['registration_number', 'no_registrasi', 'noreg', 'no_reg'])) {
                $mapped[] = 'registration_number';
            } elseif (in_array($h, ['title', 'judul', 'judul_buku'])) {
                $mapped[] = 'title';
            } elseif (in_array($h, ['author', 'penulis', 'pengarang', 'penulis_pengarang'])) {
                $mapped[] = 'author';
            } elseif ($h === 'isbn') {
                $mapped[] = 'isbn';
            } elseif (in_array($h, ['publisher', 'penerbit'])) {
                $mapped[] = 'publisher';
            } elseif (in_array($h, ['publication_year', 'tahun', 'tahun_terbit'])) {
                $mapped[] = 'publication_year';
            } elseif (in_array($h, ['klasifikasi', 'klas'])) {
                $mapped[] = 'klasifikasi';
            } elseif (in_array($h, ['edisi', 'edition'])) {
                $mapped[] = 'edisi';
            } elseif (in_array($h, ['category', 'subjek', 'kategori', 'subjek_kategori'])) {
                $mapped[] = 'category';
            } elseif (in_array($h, ['stock', 'jumlah', 'jumlah_total', 'stok'])) {
                $mapped[] = 'stock';
            } else {
                $mapped[] = $h;
            }
        }
        return $mapped;
    }

    /**
     * Normalize a row from import to DB-ready format
     */
    private function normalizeRow(array $assoc): array
    {
        return [
            'no'                  => $assoc['no'] ?? null,
            'registration_number' => $assoc['registration_number'] ?? null,
            'title'               => $assoc['title'] ?? null,
            'author'              => $assoc['author'] ?? null,
            'isbn'                => $assoc['isbn'] ?? null ?: null,
            'publisher'           => $assoc['publisher'] ?? null,
            'publication_year'    => !empty($assoc['publication_year']) ? (int)$assoc['publication_year'] : null,
            'klasifikasi'         => $assoc['klasifikasi'] ?? null,
            'edisi'               => $assoc['edisi'] ?? null,
            'category'            => $assoc['category'] ?? null,
            'stock'               => isset($assoc['stock']) && $assoc['stock'] !== '' ? (int)$assoc['stock'] : 1,
            'status'              => 'available',
        ];
    }
}