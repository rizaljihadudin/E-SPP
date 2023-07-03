<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\KwitansiPembayaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\WaliSiswaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Middleware\Wali;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {

    /** Route untuk Operator */
    Route::get('beranda', [App\Http\Controllers\Operator\BerandaController::class, 'index'])->name('operator.beranda');
    Route::resource('user', UserController::class);
    Route::resource('wali', WaliController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('walisiswa', WaliSiswaController::class);
    Route::get('kwitansi-pembayaran/{id}', [KwitansiPembayaranController::class, 'print'])->name('kwitansipembayaran.print');
});

Route::prefix('wali')->middleware(['auth', 'auth.wali'])->group(function () {

    /** Route untuk Wali */
    Route::get('beranda', [App\Http\Controllers\Wali\BerandaController::class, 'index'])->name('wali.beranda');
});

Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    /** Route untuk Admin */
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
