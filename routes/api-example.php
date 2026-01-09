<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Login/Register/Token
Route::post('/create-token-login', [AuthController::class, 'tokenLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    // untuk admin
    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('siswa', SiswaController::class);
        Route::apiResource('guru', GuruController::class);
        Route::apiResource('kelas', KelasController::class);

        // Pelanggaran
        Route::prefix('pelanggaran')
            ->controller(PelanggaranController::class)
            ->group(function () {
                Route::get('/', 'indexPelanggaran');
                Route::post('/create-pelanggaran', 'storePelanggaran');
                Route::get('/show/{id}', 'showPelanggaran');
                Route::get('/siswa/{id}', 'getBySiswa');
                Route::patch('/update/{id}', 'updatePelanggaran');
                Route::delete('/delete/{id}', 'deletePelanggaran');
                Route::get('/jenis-pelanggaran', 'indexJenisPelanggaran');
                Route::get('/jenis-pelanggaran/{id}', 'showJenisPelanggaran');
                Route::post('/jenis-pelanggaran/create', 'storeJenisPelanggaran');
                Route::patch('/jenis-pelanggaran/{id}', 'updateJenisPelanggaran');
                Route::delete('/jenis-pelanggaran/{id}', 'deleteJenisPelanggaran');
            });
    });

    // guru BK
    Route::middleware(['role:guru_bk'])->group(function () {
        // Pelanggaran - guru BK
        Route::prefix('pelanggaran')
            ->controller(PelanggaranController::class)
            ->group(function () {
                Route::get('/', 'indexPelanggaran');
                Route::post('/create-pelanggaran', 'storePelanggaran');
                Route::get('/show/{id}', 'showPelanggaran');
                Route::get('/siswa/{id}', 'getBySiswa');
                Route::patch('/update/{id}', 'updatePelanggaran');
                Route::delete('/delete/{id}', 'deletePelanggaran');
                Route::get('/jenis-pelanggaran', 'indexJenisPelanggaran');
                Route::get('/jenis-pelanggaran/{id}', 'showJenisPelanggaran');
                Route::post('/jenis-pelanggaran/create', 'storeJenisPelanggaran');
                Route::patch('/jenis-pelanggaran/{id}', 'updateJenisPelanggaran');
                Route::delete('/jenis-pelanggaran/{id}', 'deleteJenisPelanggaran');
            });
    });

    // guru piket
    Route::middleware(['role:guru_piket'])->group(function () {
        // Pelanggaran guru piket
        Route::prefix('pelanggaran')
            ->controller(PelanggaranController::class)
            ->group(function () {
                Route::get('/', 'indexPelanggaran');
                Route::post('/create-pelanggaran', 'storePelanggaran');
                Route::get('/show/{id}', 'showPelanggaran');
                Route::get('/siswa/{id}', 'getBySiswa');
                Route::patch('/update/{id}', 'updatePelanggaran');
                Route::get('/jenis-pelanggaran', 'indexJenisPelanggaran');
                Route::get('/jenis-pelanggaran/{id}', 'showJenisPelanggaran');
                Route::post('/jenis-pelanggaran/create', 'storeJenisPelanggaran');
                Route::patch('/jenis-pelanggaran/{id}', 'updateJenisPelanggaran');
            });
    });
});
