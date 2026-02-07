<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Login Routes
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->middleware('guest')->name('login.store');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/contact', function () {
    return view('contact');
});
Route::get('/sejarah', function () {
    return view('sejarah');
});
Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/tentang', function () {
    return view('tentang');
});

// Register Routes
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->middleware('guest')->name('register.store');
Route::get('/member/{id}/card', [\App\Http\Controllers\Auth\RegisterController::class, 'card'])->name('member.card');
Route::get('/member/{id}/download-pdf', [\App\Http\Controllers\Auth\RegisterController::class, 'downloadPdf'])->name('member.download-pdf');

// Peminjaman Online Routes - harus login
Route::middleware('member.auth')->group(function () {
    Route::get('/peminjaman', [\App\Http\Controllers\Peminjaman\PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman', [\App\Http\Controllers\Peminjaman\PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/riwayat', [\App\Http\Controllers\Peminjaman\PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
});

// Signature & Stamp Management (Admin)
Route::get('/admin/signature-stamp', [\App\Http\Controllers\Admin\SignatureStampController::class, 'form'])->name('signature-stamp.form');
Route::post('/admin/signature-stamp', [\App\Http\Controllers\Admin\SignatureStampController::class, 'upload'])->name('signature-stamp.upload');