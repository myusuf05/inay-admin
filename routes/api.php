<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiKelasController;
use App\Http\Controllers\Api\ApiNilaiController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Api\ApiJadwalController;
use App\Http\Controllers\Api\ApiSantriController;
use App\Http\Controllers\Api\ApiKeamananController;
use App\Http\Controllers\Api\ApiPengajarController;
use App\Http\Controllers\Pendataan\SantriController;

Route::get('santri/{id}', [ApiSantriController::class, 'get']);

Route::get('kelas', [ApiKelasController::class, 'get_kelas']);
Route::get('jadwal', [ApiJadwalController::class, 'get_jadwal']);
Route::get('nilai', [ApiNilaiController::class, 'get_nilai']);
Route::get('pengajar', [ApiPengajarController::class, 'get_pengajar']);
Route::get('keamanan', [ApiKeamananController::class, 'get_keamanan']);
Route::post('auth/session', [ApiAuthController::class, 'login']);
Route::get('getEmail', [SantriController::class, 'get_email_santri']);

// Route::get('santri/test', [SantriController::class, 'test']);
Route::get('/test', [SantriController::class, 'test']);

// Route::get('test', function () {
//     return response()->json(['message' => 'Test route works']);
// });