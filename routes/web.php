<?php

use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\PerpussController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginStore')->name('login.store');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerStore')->name('register.store');
    Route::get('logout', 'logout')->name('logout');
});

Route::controller(AdminRegistrationController::class)->prefix('login')->group(function () {
    Route::get('/admin','login')->name('admin.login');
    Route::post('/admin','loginStore')->name('admin.login.store');
    Route::get('/register-admin', 'create')->name('admin.register');
    Route::post('/register-admin', 'store')->name('admin.register.store');
    Route::post('/logout','logout')->name('admin.logout');
    Route::get('/dashboard', 'index')->name('admin.dashboard');
});
Route::controller(BookController::class)->prefix('digital')->group(function () {
    Route::get('/', 'index')->name('admin.books.index');
    Route::post('/', 'store')->name('admin.books.store');
    Route::get('/create', 'create')->name('admin.books.create');
    Route::delete('/{perpuss}', 'destroy')->name('admin.books.destroy');
    Route::get('/show', 'show')->name('admin.books.show');

});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');
    Route::get('katalog', 'katalog')->name('katalog');
    Route::get('sejarah', 'sejarah')->name('sejarah');
    Route::get('tentang', 'tentang')->name('tentang');
    Route::get('contact', 'contact')->name('contact');
});
Route::controller(PeminjamanController::class)->prefix('peminjaman')->group(function () {
    Route::get('/', 'index')->name('peminjaman.show');
    Route::post('/', 'store')->name('peminjaman.store');
    Route::get('/riwayat', 'riwayat')->name('peminjaman.riwayat');
    Route::get('/baca/{book}', 'read')->name('peminjaman.read');
    Route::get('/baca/{book}/stream', 'stream')->name('peminjaman.read.stream');
});

Route::controller(PerpussController::class)->prefix('perpuss')->group(function () {
    Route::get('/', 'index')->name('admin.books.library.index');
    Route::post('/', 'store')->name('admin.books.library.store');
    Route::get('/create', 'create')->name('admin.books.library.create');
    Route::delete('/{perpuss}', 'destroy')->name('admin.books.library.destroy');
    Route::get('/show', 'show')->name('admin.books.library.show');
});
