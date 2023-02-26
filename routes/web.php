<?php

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
});
