<?php

use App\Http\Livewire\ShowPosts;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DptController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\CalegController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SaksiController;
use App\Http\Controllers\SuaraController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\PendukungController;

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

Route::get('/', [DptController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Rute yang akan diterapkan middleware 'auth'

    Route::post('/import', [ImportController::class, 'index'])->name('import.prosess');
    Route::get('/get-import', [ImportController::class, 'show'])->name('import.show');
    Route::get('/export-pendukung', [ExportController::class, 'index'])->name('export.index');

    Route::get('/caleg', [CalegController::class, 'index'])->name('caleg.index');
    Route::get('/pendukung', [PendukungController::class, 'index'])->name('pendukung.index');

    Route::get('/pengguna', [RelawanController::class, 'index'])->name('relawan.index');
    Route::get('/saksi', [SaksiController::class, 'index'])->name('saksi.index');
    Route::get('/tps', [TpsController::class, 'index'])->name('tps.index');
    Route::get('/suara', [SuaraController::class, 'index'])->name('suara.index');
    Route::post('/suara/hitung', [SuaraController::class, 'hitung'])->name('suara.hitung');
    Route::get('/input-suara', [SuaraController::class, 'input_suara'])->name('suara.input');

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/pertps', [ReportController::class, 'pertps'])->name('report.pertps');
    Route::get('/report/percaleg', [ReportController::class, 'percaleg'])->name('report.percaleg');

});