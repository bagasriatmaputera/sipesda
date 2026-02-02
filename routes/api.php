<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BobotRulesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SawPropertyController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Data Master
Route::apiResource('siswa', SiswaController::class);
Route::apiResource('guru', GuruController::class);
Route::apiResource('kelas', KelasController::class);
Route::apiResource('bobot', BobotRulesController::class);

// Pelanggaran
Route::prefix('pelanggaran')->controller(PelanggaranController::class)->group(function () {
    Route::get('/', 'indexPelanggaran');
    Route::post('/create-pelanggaran', 'storePelanggaran');
    Route::get('/show/{id}', 'showPelanggaran');
    Route::get('/siswa/{id}', 'getBySiswa');
    Route::patch('/update/{id}', 'updatePelanggaran');
    Route::delete('/delete/{id}', 'deletePelanggaran');
    // Jenis Pelanggaran
    Route::get('/jenis-pelanggaran', 'indexJenisPelanggaran');
    Route::get('/jenis-pelanggaran/{id}', 'showJenisPelanggaran');
    Route::post('/jenis-pelanggaran/create', 'storeJenisPelanggaran');
    Route::patch('/jenis-pelanggaran/{id}', 'updateJenisPelanggaran');
    Route::delete('/jenis-pelanggaran/{id}', 'deleteJenisPelanggaran');
});

Route::prefix('saw')->controller(SawPropertyController::class)->group(function () {
    Route::prefix('tahap')->group(function () {
        Route::get('/', 'indexTahap');
        Route::get('/{id}', 'showTahap');
        Route::post('/create', 'storeTahap');
        Route::patch('/{id}', 'updateTahap');
        Route::delete('/{id}', 'destroyTahap');
    });
    Route::prefix('kriteria')->group(function () {
        Route::get('/', 'indexKriteria');
        Route::get('/{id}', 'showKriteria');
        Route::post('/create', 'storeKriteria');
        Route::patch('/{id}', 'updateKriteria');
        Route::delete('/{id}', 'destroyKriteria');
    });
    Route::prefix('hasil')->group(function () {
        Route::get('/', 'indexHasilSaw');
        Route::get('/ranking', 'rankingSaw');
    });
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/total-pelanggaran', 'countPelanggaran');
    Route::get('/siswa-big-poin', 'getSiswaWith50Poin');
    Route::get('/pelanggaran-per-week', 'pelanggaranPerWeek');
    Route::get('/total-siswa-terlanggar', 'countSiswaWithPelanggaran');
    Route::get('/chart-by-month', 'pelanggaranPerMonth');
});

Route::get('/siswa/export-pdf/{id}', [SiswaController::class, 'exportPdf']);

// Route SPK (Nanti kalau sudah buat)
// Route::get('/spk/prioritas', [SPKController::class, 'index']);
