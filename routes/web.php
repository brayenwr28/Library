<?php

use App\Http\Controllers\Admin\PerpussController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginStore')->name('login.store');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerStore')->name('register.store');
    Route::get('logout', 'logout')->name('logout');
});
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
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
        Route::get('/', 'index')->name('Bukuperpus.index');
        Route::post('/', 'store')->name('Bukuperpus.store');
        Route::get('/create', 'create')->name('Bukuperpus.create');
        Route::delete('/{perpuss}', 'destroy')->name('Bukuperpus.destroy');
    });
