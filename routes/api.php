<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Data Master
Route::apiResource('siswa', SiswaController::class);
Route::apiResource('guru', GuruController::class);
Route::apiResource('kelas', KelasController::class);

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

// Route SPK (Nanti kalau sudah buat)
// Route::get('/spk/prioritas', [SPKController::class, 'index']);
