<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaceRecognationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\WilayahController;
use App\Models\Tps;

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

Route::get('/', [AuthController::class, 'viewLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::middleware(['kpu'])->group(function () {
        Route::prefix('kpu')->group(function () {
            Route::prefix('tps')->group(function () {
                Route::get('/', [TpsController::class, 'getTps']);
                Route::post('/', [TpsController::class, 'postTps']);
                Route::post('/store', [TpsController::class, 'storeTps']);
            });
            Route::prefix('penduduk')->group(function () {
                Route::get('/', [PendudukController::class, 'getPenduduk']);
                Route::get('/export', [PendudukController::class, 'exportPenduduk']);
                Route::post('/', [PendudukController::class, 'postPenduduk']);
                Route::post('/import', [PendudukController::class, 'importPenduduk']);
                Route::post('/store', [PendudukController::class, 'storePenduduk']);
            });
            Route::prefix('monitoring')->group(function () {
                Route::get('/pemilu', [MonitoringController::class, 'getMonitoringPemilu']);
                Route::post('/pemilu', [MonitoringController::class, 'postMonitoringPemilu']);
            });
            Route::prefix('setting')->group(function () {
                Route::get('/aksi', [SettingController::class, 'getSettingAksi']);
                Route::post('/aksi', [SettingController::class, 'postSettingAksi']);
            });
        });
    });

    Route::middleware(['ppl'])->group(function () {
        Route::prefix('ppl')->group(function () {
            Route::prefix('tps')->group(function () {
                Route::get('/', [TpsController::class, 'getTps']);
                Route::post('/update', [TpsController::class, 'updateTps']);
            });
            Route::prefix('penduduk')->group(function () {
                Route::get('/', [PendudukController::class, 'getPenduduk']);
            });
            Route::prefix('antrean')->group(function () {
                Route::get('/', [TpsController::class, 'getAntrean']);
            });
            Route::prefix('monitoring')->group(function () {
                Route::get('/pemilu', [MonitoringController::class, 'getMonitoringPemilu']);
            });
            Route::prefix('face-recognation')->group(function () {
                Route::get('/', [FaceRecognationController::class, 'getFaceRecognation']);
                Route::get('/daftar', [FaceRecognationController::class, 'daftarFaceRecognation']);
                Route::get('/akhir/{id}', [FaceRecognationController::class, 'getFaceRecognationAkhir']);
                Route::post('/daftar', [FaceRecognationController::class, 'postFaceRecognationDaftar']);
                Route::post('/awal', [FaceRecognationController::class, 'postFaceRecognationAwal']);
                Route::post('/akhir', [FaceRecognationController::class, 'postFaceRecognationAkhir']);
            });
        });
    });

    Route::prefix('dropdownlist')->group(function () {
        Route::get('/getkotakab/{provinsi_id}', [WilayahController::class, 'getKotaKab']);
        Route::get('/getkecamatan/{kota_kab_id}', [WilayahController::class, 'getKecamatan']);
        Route::get('/getkelurahan/{kecamatan_id}', [WilayahController::class, 'getKelurahan']);
        Route::get('/gettps/{kota_kab_id}/{kecamatan_id}/{kelurahan_id}', [TpsController::class, 'getListTps']);
    });
});