<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankSekolahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\KartuSppController;
use App\Http\Controllers\KwitansiPembayaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\WaliSiswaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\LaporanFormController;
use App\Http\Controllers\Wali\SiswaController as WaliMuridSiswaController;
use App\Http\Controllers\Wali\TagihanController as WaliMuridTagihanController;
use App\Http\Controllers\Wali\PembayaranController as WaliMuridPembayaranController;
use App\Http\Controllers\Wali\ProfileController as WaliMuridProfileController;
use App\Http\Controllers\Wali\InvoiceController as InvoiceController;
use App\Http\Middleware\Wali;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

// Route::get('tes', function () {
//     echo URL::temporarySignedRoute(
//         'login.url',
//         now()->addDays(30),
//         [
//             'pembayaran_id' => 1,
//             'user_id'       => 2,
//             'url'           => route('pembayaran.show', 1)
//         ]
//     );
// });

Route::get('login/login-url', [LoginController::class, 'loginUrl'])->name('login.url');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('login-wali', [LoginController::class, 'showLoginFormWali'])->name('login.wali');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('panduan-pembayaran/{id}', [PanduanController::class, 'index'])->name('panduan.pembayaran');
Route::resource('invoice', InvoiceController::class);
Route::get('kwitansi-pembayaran/{id}', [KwitansiPembayaranController::class, 'print'])->name('kwitansipembayaran.print')->middleware('auth');
Route::get('kartu-spp', [KartuSppController::class, 'index'])->name('kartuspp.index')->middleware('auth');
Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {

    /** Route untuk Operator */
    Route::get('beranda', [App\Http\Controllers\Operator\BerandaController::class, 'index'])->name('operator.beranda');
    Route::resource('banksekolah', BankSekolahController::class);
    Route::resource('user', UserController::class);
    Route::resource('wali', WaliController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('walisiswa', WaliSiswaController::class);
    Route::resource('setting', SettingController::class);
    Route::get('delete-biaya-item/{id}', [BiayaController::class, 'deleteItem'])->name('delete.biaya.item');
    Route::get('status/update', [StatusController::class, 'update'])->name('status.update');

    //Laporan
    Route::get('laporanform/create', [LaporanFormController::class, 'create'])->name('laporanform.create');
    Route::get('laporanform/laporan-tagihan', [LaporanFormController::class, 'showLaporanTagihan'])->name('laporanform.show.laporantagihan');
});

Route::prefix('wali')->middleware(['auth', 'auth.wali'])->name('wali.')->group(function () {
    /** Route untuk Wali */
    Route::get('beranda', [App\Http\Controllers\Wali\BerandaController::class, 'index'])->name('beranda');
    Route::resource('siswa', WaliMuridSiswaController::class);
    Route::resource('tagihan', WaliMuridTagihanController::class);
    Route::resource('pembayaran', WaliMuridPembayaranController::class);
    Route::resource('profile', WaliMuridProfileController::class);
});

Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    /** Route untuk Admin */
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
