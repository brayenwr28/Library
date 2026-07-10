<?php

/**
 * Script untuk mengekstrak data buku dari file SQL stmik_pustaka.sql
 * dan mengekspornya ke file Excel (data_buku.xlsx)
 *
 * Jalankan dengan: php export_buku_sql_to_excel.php
 */

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

echo "📖 Membaca file SQL...\n";

$sqlFile = __DIR__ . '/stmik_pustaka.sql';
if (!file_exists($sqlFile)) {
    die("❌ File stmik_pustaka.sql tidak ditemukan!\n");
}

// Baca file SQL dan cari INSERT INTO blbogrf
$content = file_get_contents($sqlFile);

// Ambil bagian INSERT INTO blbogrf
// Kolom: bbkd, bbjdl(judul), pengarang, jdlsr, bbnoreg(noreg), bbjmlh(jumlah),
//        tkid, bbisbn, penerbit, bbthn(tahun), bbtmpt, bbklas(klasifikasi),
//        bbeds(edisi), bbsbyk(subjek), bbcttnutm(catatan), bdid, sdid, ddid, rid,
//        bbabstrk, bbsmpldpn, bbsmplblkg, bbinpt, uid

echo "🔍 Mencari data tabel blbogrf (buku)...\n";

// Gunakan regex untuk menemukan semua baris INSERT VALUES
$pattern = '/INSERT INTO `blbogrf`.*?VALUES\s*(.*?);/s';
if (!preg_match($pattern, $content, $match)) {
    die("❌ Tidak menemukan data tabel blbogrf di SQL!\n");
}

$valuesBlock = $match[1];

// Parse setiap baris nilai
// Format: (id, 'judul', 'pengarang', 'jdlsr', 'noreg', jumlah, 'tkid', 'isbn', 'penerbit', tahun, 'tmpt', 'klas', 'eds', 'sbyk', 'catatan', 'bdid', 'sdid', 'ddid', 'rid', 'abstrak', 'smpldpn', 'smplblkg', 'tgl', 'uid')
$rows = [];
$pattern2 = '/\((\d+),\s*(.*?)\)(?:,\s*\n|\s*$)/s';

// Ekstrak semua baris values dengan lebih teliti
// Split berdasarkan baris data
$lines = explode("\n", $valuesBlock);
$currentRow = '';
$allRows = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line)) continue;

    $currentRow .= ' ' . $line;

    // Hitung jumlah tanda kurung untuk mendeteksi akhir baris data
    $openCount = substr_count($currentRow, '(');
    $closeCount = substr_count($currentRow, ')');

    if ($openCount > 0 && $openCount <= $closeCount) {
        // Bersihkan trailing koma dan spasi
        $rowData = trim($currentRow, " ,\n\r");
        if (!empty($rowData)) {
            $allRows[] = $rowData;
        }
        $currentRow = '';
    }
}

echo "✅ Menemukan " . count($allRows) . " entri buku.\n";

// Parse setiap row menjadi array kolom
$books = [];
foreach ($allRows as $rowStr) {
    // Hapus tanda kurung luar
    $rowStr = trim($rowStr);
    if (!preg_match('/^\((.*)\)$/s', $rowStr, $m)) continue;
    $inner = $m[1];

    // Parse nilai dengan memperhatikan string yang mengandung koma
    $values = parseSqlValues($inner);

    if (count($values) >= 10) {
        $bbkd  = cleanVal($values[0]);
        $judul = cleanVal($values[1]);
        $penulis = cleanVal($values[2]);
        $jdlsr = cleanVal($values[3]);
        $noreg = cleanVal($values[4]);
        $jumlah = cleanVal($values[5]);
        $isbn  = cleanVal($values[7]);
        $penerbit = cleanVal($values[8]);
        $tahun = cleanVal($values[9]);
        $klasifikasi = cleanVal($values[11]);
        $edisi = cleanVal($values[12]);
        $subjek = cleanVal($values[13]);

        // Skip row pertama yang hanyua header/placeholder
        if ($judul === 'bbjdl' || $bbkd === '1') {
            // Skip jika ini row dummy pertama
            if ($judul === 'bbjdl') continue;
        }

        $books[] = [
            'no'         => $bbkd,
            'noreg'      => $noreg,
            'judul'      => $judul,
            'penulis'    => $penulis,
            'isbn'       => $isbn,
            'penerbit'   => $penerbit,
            'tahun'      => $tahun,
            'klasifikasi' => $klasifikasi,
            'edisi'      => $edisi,
            'subjek'     => $subjek,
            'jumlah'     => $jumlah,
        ];
    }
}

echo "📊 Total buku valid: " . count($books) . "\n";
echo "📝 Membuat file Excel...\n";

// Buat Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Buku Perpustakaan');

// ─── Header ──────────────────────────────────────────────────────────────────
$sheet->setCellValue('A1', 'DAFTAR BUKU PERPUSTAKAAN STMIK');
$sheet->mergeCells('A1:K1');
$sheet->getStyle('A1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF1E3A8A']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDBEAFE']],
]);
$sheet->getRowDimension(1)->setRowHeight(28);

$sheet->setCellValue('A2', 'Sumber: stmik_pustaka.sql — Diekspor pada ' . date('d/m/Y H:i'));
$sheet->mergeCells('A2:K2');
$sheet->getStyle('A2')->applyFromArray([
    'font' => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF6B7280']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

// ─── Kolom Header ─────────────────────────────────────────────────────────────
$headers = [
    'A' => 'No.',
    'B' => 'No. Registrasi',
    'C' => 'Judul Buku',
    'D' => 'Penulis / Pengarang',
    'E' => 'ISBN',
    'F' => 'Penerbit',
    'G' => 'Tahun',
    'H' => 'Klasifikasi',
    'I' => 'Edisi',
    'J' => 'Subjek / Kategori',
    'K' => 'Jumlah',
];

foreach ($headers as $col => $label) {
    $sheet->setCellValue($col . '4', $label);
}

$sheet->getStyle('A4:K4')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 10],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1D4ED8']],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER,
        'wrapText'   => true,
    ],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFB8C4E3']]],
]);
$sheet->getRowDimension(4)->setRowHeight(22);

// ─── Data Rows ────────────────────────────────────────────────────────────────
$rowNum = 5;
$counter = 1;
foreach ($books as $book) {
    $isEven = ($counter % 2 === 0);
    $bgColor = $isEven ? 'FFF0F7FF' : 'FFFAFAFA';

    $sheet->setCellValue('A' . $rowNum, $counter);
    $sheet->setCellValue('B' . $rowNum, $book['noreg']);
    $sheet->setCellValue('C' . $rowNum, $book['judul']);
    $sheet->setCellValue('D' . $rowNum, $book['penulis']);
    $sheet->setCellValue('E' . $rowNum, $book['isbn']);
    $sheet->setCellValue('F' . $rowNum, $book['penerbit']);
    $sheet->setCellValue('G' . $rowNum, $book['tahun']);
    $sheet->setCellValue('H' . $rowNum, $book['klasifikasi']);
    $sheet->setCellValue('I' . $rowNum, $book['edisi']);
    $sheet->setCellValue('J' . $rowNum, $book['subjek']);
    $sheet->setCellValue('K' . $rowNum, $book['jumlah']);

    $sheet->getStyle('A' . $rowNum . ':K' . $rowNum)->applyFromArray([
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_HAIR, 'color' => ['argb' => 'FFE2E8F0']]],
        'alignment' => ['vertical' => Alignment::VERTICAL_TOP],
    ]);

    // Wrap text untuk judul dan penulis
    $sheet->getStyle('C' . $rowNum)->getAlignment()->setWrapText(true);
    $sheet->getRowDimension($rowNum)->setRowHeight(-1); // auto height

    $rowNum++;
    $counter++;
}

// ─── Column Widths ────────────────────────────────────────────────────────────
$widths = [
    'A' => 6,
    'B' => 16,
    'C' => 50,
    'D' => 28,
    'E' => 20,
    'F' => 28,
    'G' => 8,
    'H' => 14,
    'I' => 10,
    'J' => 28,
    'K' => 8,
];
foreach ($widths as $col => $width) {
    $sheet->getColumnDimension($col)->setWidth($width);
}

// Center alignment untuk kolom No, Tahun, Jumlah
$sheet->getStyle('A5:A' . ($rowNum - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('G5:G' . ($rowNum - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('K5:K' . ($rowNum - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Freeze header row
$sheet->freezePane('A5');

// Auto filter
$sheet->setAutoFilter('A4:K4');

// ─── Ringkasan Sheet ──────────────────────────────────────────────────────────
$summarySheet = $spreadsheet->createSheet();
$summarySheet->setTitle('Ringkasan');

$summarySheet->setCellValue('A1', 'RINGKASAN DATA BUKU');
$summarySheet->mergeCells('A1:C1');
$summarySheet->getStyle('A1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FFFFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1D4ED8']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);
$summarySheet->getRowDimension(1)->setRowHeight(24);

$summarySheet->setCellValue('A3', 'Keterangan');
$summarySheet->setCellValue('B3', 'Jumlah');
$summarySheet->getStyle('A3:B3')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF3B82F6']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

$summarySheet->setCellValue('A4', 'Total Judul Buku');
$summarySheet->setCellValue('B4', count($books));
$summarySheet->setCellValue('A5', 'Total Eksemplar (jumlah)');
$totalExemplar = array_sum(array_column($books, 'jumlah'));
$summarySheet->setCellValue('B5', $totalExemplar);
$summarySheet->setCellValue('A6', 'Sumber Data');
$summarySheet->setCellValue('B6', 'stmik_pustaka.sql');
$summarySheet->setCellValue('A7', 'Tanggal Export');
$summarySheet->setCellValue('B7', date('d/m/Y H:i:s'));

$summarySheet->getColumnDimension('A')->setWidth(30);
$summarySheet->getColumnDimension('B')->setWidth(20);

foreach (range(4, 7) as $r) {
    $bg = $r % 2 === 0 ? 'FFF0F9FF' : 'FFFAFAFA';
    $summarySheet->getStyle('A' . $r . ':B' . $r)->applyFromArray([
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bg]],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_HAIR]],
    ]);
}

// ─── Simpan File ──────────────────────────────────────────────────────────────
$spreadsheet->setActiveSheetIndex(0); // Kembali ke sheet utama

$outputFile = __DIR__ . '/data_buku.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($outputFile);

echo "✅ File Excel berhasil dibuat: data_buku.xlsx\n";
echo "📊 Total buku diekspor: " . count($books) . " judul\n";
echo "📦 Total eksemplar: $totalExemplar\n";
echo "\nSelesai! Buka file data_buku.xlsx untuk melihat hasilnya.\n";

// ─── Helper Functions ─────────────────────────────────────────────────────────

function parseSqlValues(string $str): array {
    $values = [];
    $i = 0;
    $len = strlen($str);

    while ($i < $len) {
        // Skip whitespace dan koma
        while ($i < $len && in_array($str[$i], [' ', ',', "\n", "\r", "\t"])) {
            $i++;
        }
        if ($i >= $len) break;

        if ($str[$i] === "'") {
            // String value
            $i++; // skip opening quote
            $val = '';
            while ($i < $len) {
                if ($str[$i] === '\\' && $i + 1 < $len) {
                    // Escape sequence
                    $next = $str[$i + 1];
                    if ($next === "'") $val .= "'";
                    elseif ($next === '\\') $val .= '\\';
                    elseif ($next === 'n') $val .= "\n";
                    else $val .= $str[$i + 1];
                    $i += 2;
                } elseif ($str[$i] === "'") {
                    $i++; // skip closing quote
                    break;
                } else {
                    $val .= $str[$i];
                    $i++;
                }
            }
            $values[] = $val;
        } else {
            // Numeric or NULL value
            $val = '';
            while ($i < $len && !in_array($str[$i], [',', ' ', "\n"])) {
                $val .= $str[$i];
                $i++;
            }
            $values[] = $val;
        }
    }

    return $values;
}

function cleanVal(?string $val): string {
    if ($val === null) return '';
    $val = trim($val);
    // Ganti tanda - atau kosong dengan string kosong
    if ($val === '-' || $val === '--') return '';
    return $val;
}
