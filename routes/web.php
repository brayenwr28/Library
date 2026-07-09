<?php

use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\PengunjungController;
use App\Http\Controllers\Admin\PerpussController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KartuAnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->middleware('guest')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginStore')->name('login.store');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerStore')->name('register.store');
});

Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::controller(AdminRegistrationController::class)->group(function () {
    Route::get('/admin','login')->name('admin.login');
    Route::post('/admin','loginStore')->name('admin.login.store');
});

Route::middleware('auth:admin')->controller(AdminRegistrationController::class)->group(function () {
    Route::get('/register-admin', 'create')->name('admin.register');
    Route::post('/register-admin', 'store')->name('admin.register.store');
});

// Admin Protected Routes - requires authentication
Route::controller(AdminRegistrationController::class)->prefix('login')->middleware('auth:admin')->group(function () {
    Route::post('/logout','logout')->name('admin.logout');
    Route::get('/dashboard', 'index')->name('admin.dashboard');
});
Route::middleware('auth:admin')->controller(BookController::class)->prefix('digital')->group(function () {
    Route::get('/', 'index')->name('admin.books.index');
    Route::post('/', 'store')->name('admin.books.store');
    Route::get('/create', 'create')->name('admin.books.create');
    Route::get('/{book}/edit', 'edit')->name('admin.books.edit');
    Route::put('/{book}', 'update')->name('admin.books.update');
    Route::delete('/{book}', 'destroy')->name('admin.books.destroy');
    Route::get('/show', 'show')->name('admin.books.show');

});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');
    Route::get('/dashboard', 'index')->name('dashboard.alias');
    Route::get('katalog', 'katalog')->name('katalog');
    Route::get('sejarah', 'sejarah')->name('sejarah');
    Route::get('tentang', 'tentang')->name('tentang');
    Route::get('contact', 'contact')->name('contact');
    Route::get('laporan', function () {
        return redirect()->route('admin.report.index');
    })->name('laporan');
});
Route::controller(PeminjamanController::class)->prefix('peminjaman')->group(function () {
    Route::get('/', 'index')->name('peminjaman.show');
    Route::post('/', 'store')->name('peminjaman.store');
    Route::get('/katalog', 'katalogForm')->name('peminjaman.katalog');
    Route::get('/perpus', 'perpusForm')->name('peminjaman.perpus');
    Route::get('/riwayat', 'riwayat')->name('peminjaman.riwayat');
    Route::get('/riwayat/download-pdf', 'downloadRiwayatPdf')->name('peminjaman.riwayat.download');
    Route::get('/baca/{book}', 'read')->name('peminjaman.read');
    Route::get('/baca/{book}/stream', 'stream')->name('peminjaman.read.stream');
});

Route::middleware('auth:admin')->controller(PerpussController::class)->prefix('perpuss')->group(function () {
    Route::get('/', 'index')->name('admin.books.library.index');
    Route::post('/', 'store')->name('admin.books.library.store');
    Route::get('/create', 'create')->name('admin.books.library.create');
    Route::get('/show', 'show')->name('admin.books.library.show');
    Route::get('/import', 'importForm')->name('admin.books.library.import.form');
    Route::post('/import', 'importProcess')->name('admin.books.library.import.process');
    Route::get('/{perpuss}/edit', 'edit')->name('admin.books.library.edit');
    Route::put('/{perpuss}', 'update')->name('admin.books.library.update');
    Route::delete('/{perpuss}', 'destroy')->name('admin.books.library.destroy');
});

// KTM Routes
Route::middleware('auth')->controller(KartuAnggotaController::class)->prefix('ktm')->group(function () {
    Route::get('/', 'index')->name('ktm.index');
    Route::get('/download', 'downloadPDF')->name('ktm.download');
    Route::get('/{member_id}', 'show')->name('ktm.show');
});

// Profile Routes
Route::middleware('auth')->controller(KartuAnggotaController::class)->prefix('profile')->group(function () {
    Route::get('/edit', 'edit')->name('profile.edit');
    Route::put('/update', 'update')->name('profile.update');
});

// Pengunjung Routes
Route::controller(PengunjungController::class)->prefix('pengunjung')->group(function () {
    Route::get('/form', 'show')->name('pengunjung.form');
    Route::post('/', 'store')->name('pengunjung.store');
});

Route::middleware('auth:admin')->controller(PengunjungController::class)->prefix('pengunjung')->group(function () {
    Route::get('/', 'index')->name('pengunjung.index');
    Route::get('/{pengunjung}/edit', 'edit')->name('pengunjung.edit');
    Route::put('/{pengunjung}', 'update')->name('pengunjung.update');
    Route::delete('/{pengunjung}', 'destroy')->name('pengunjung.destroy');
});

// Admin Confirmation Routes - Peminjaman
Route::middleware('auth:admin')->controller(PeminjamanController::class)->prefix('admin/peminjaman')->group(function () {
    Route::get('/menunggu', 'indexMenungguKonfirmasi')->name('admin.peminjaman.menunggu');
    Route::put('/{peminjaman}/konfirmasi', 'konfirmasiPeminjaman')->name('admin.peminjaman.konfirmasi');
    Route::put('/{peminjaman}/tolak', 'tolakPeminjaman')->name('admin.peminjaman.tolak');
});

// Admin Confirmation Routes - Pengembalian
Route::middleware('auth:admin')->controller(PengembalianController::class)->prefix('admin/pengembalian')->group(function () {
    Route::get('/', 'index')->name('admin.pengembalian.index');
    Route::get('/{peminjaman}/create', 'createForm')->name('admin.pengembalian.create');
    Route::post('/', 'store')->name('admin.pengembalian.store');
    Route::get('/menunggu', 'indexMenunggu')->name('admin.pengembalian.menunggu');
    Route::get('/{pengembalian}', 'show')->name('admin.pengembalian.show');
    Route::put('/{pengembalian}/terima', 'terima')->name('admin.pengembalian.terima');
    Route::put('/{pengembalian}/tolak', 'tolak')->name('admin.pengembalian.tolak');
});

// Admin Report Routes
Route::middleware('auth:admin')->controller(\App\Http\Controllers\Admin\AdminReportController::class)->prefix('admin/reports')->group(function () {
    Route::get('/', 'index')->name('admin.report.index');
    
    Route::get('/peminjaman', 'laporanPeminjaman')->name('admin.report.peminjaman');
    Route::get('/peminjaman/export-pdf', 'exportPeminjamanPdf')->name('admin.report.peminjaman.export');
    
    Route::get('/pengembalian', 'laporanPengembalian')->name('admin.report.pengembalian');
    Route::get('/pengembalian/export-pdf', 'exportPengembalianPdf')->name('admin.report.pengembalian.export');
    
    Route::get('/pengunjung', 'laporanPengunjung')->name('admin.report.pengunjung');
    Route::get('/pengunjung/export-pdf', 'exportPengunjungPdf')->name('admin.report.pengunjung.export');
    
    Route::get('/anggota', 'laporanAnggota')->name('admin.report.anggota');
    Route::get('/anggota/export-pdf', 'exportAnggotaPdf')->name('admin.report.anggota.export');

    Route::get('/denda', 'laporanDenda')->name('admin.report.denda');
    Route::get('/denda/export-pdf', 'exportDendaPdf')->name('admin.report.denda.export');
    Route::put('/denda/{pengembalian}/lunas', 'bayarDenda')->name('admin.report.denda.lunas');
});

// Admin Import Routes (Books & Members)
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    // Books import
    Route::get('books/import', [\App\Http\Controllers\Admin\BookController::class, 'importForm'])->name('admin.books.import.form');
    Route::post('books/import', [\App\Http\Controllers\Admin\BookController::class, 'importProcess'])->name('admin.books.import.process');

    // Members
    Route::get('members/import', [\App\Http\Controllers\Admin\MemberController::class, 'importForm'])->name('admin.members.import.form');
    Route::post('members/import', [\App\Http\Controllers\Admin\MemberController::class, 'importProcess'])->name('admin.members.import.process');
    Route::get('members/{member}/edit', [\App\Http\Controllers\Admin\MemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('members/{member}', [\App\Http\Controllers\Admin\MemberController::class, 'update'])->name('admin.members.update');
    Route::delete('members/{member}', [\App\Http\Controllers\Admin\MemberController::class, 'destroy'])->name('admin.members.destroy');
});

// AJAX chart data for admin dashboard
Route::middleware('auth:admin')->get('admin/dashboard/chart-data', [\App\Http\Controllers\Admin\AdminRegistrationController::class, 'chartData'])->name('admin.dashboard.chart');

// Admin profile (short) - view & update
Route::middleware('auth:admin')->controller(\App\Http\Controllers\Admin\AdminRegistrationController::class)->prefix('admin')->group(function () {
    Route::get('/profile', 'profileEdit')->name('admin.profile.edit');
    Route::put('/profile', 'profileUpdate')->name('admin.profile.update');
});

