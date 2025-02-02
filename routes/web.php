<?php

use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Pendataan\AlamatController;
use App\Http\Controllers\Pendataan\DashboardController;
use App\Http\Controllers\Pendataan\KelasController;
use App\Http\Controllers\Pendataan\KamarController;
use App\Http\Controllers\Pendataan\Setting\PendidikanController;
use App\Http\Controllers\Pendataan\Setting\PekerjaanController;
use App\Http\Controllers\Pendataan\Setting\GajiController;
use App\Http\Controllers\Pendataan\Setting\StatusSantriController;
use App\Http\Controllers\Pendataan\DataIndukController;
use App\Http\Controllers\Pendataan\SantriController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Akademik\JadwalController;
use App\Http\Controllers\Akademik\MapelController;
use App\Http\Controllers\Akademik\NilaiController;
use App\Http\Controllers\Akademik\PengajarController;
use App\Http\Controllers\Akademik\PresensiController;
use App\Http\Controllers\Pendataan\AlumniController;
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

// Auth 
Route::middleware(['guest'])->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::get('/', [SessionController::class, 'index'])->name('login');
        Route::post('/login', [SessionController::class, 'login']);
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/auth/logout', [SessionController::class, 'logout']);
    Route::prefix('pendataan')->group(function () {
        Route::prefix('kamar')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('/', [KamarController::class, 'index']);
            Route::get('list', [KamarController::class, 'get_list']);
            Route::post('data', [KamarController::class, 'get_data']);
            Route::post('add', [KamarController::class, 'store']);
            Route::get('{id}', [KamarController::class, 'show']);
            Route::put('{id}', [KamarController::class, 'update']);
            Route::delete('{id}', [KamarController::class, 'destroy']);

            Route::prefix('detail')->group(function () {
                Route::get('{id}', [KamarController::class, 'see_occupants']);
                Route::post('add', [KamarController::class, 'add_occupants']);
                Route::post('{id}', [KamarController::class, 'get_occupants']);
                Route::delete('{id}', [KamarController::class, 'delete_occupants']);
            });
        });

        Route::prefix('setting/data')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('/', [DataIndukController::class, 'index']);

            Route::prefix('pekerjaan')->group(function () {
                Route::post('/', [PekerjaanController::class, 'get_data']);
                Route::post('add', [PekerjaanController::class, 'store']);
                Route::get('/all', [PekerjaanController::class, 'get_all']);
                Route::post('{id}', [PekerjaanController::class, 'show']);
                Route::put('edit/{id}', [PekerjaanController::class, 'update']);
                Route::delete('delete/{id}', [PekerjaanController::class, 'destroy']);
                Route::put('active/{id}', [PekerjaanController::class, 'active']);
            });

            Route::prefix('pendidikan')->group(function () {
                Route::post('/', [PendidikanController::class, 'get_data']);
                Route::post('add', [PendidikanController::class, 'store']);
                Route::get('/all', [PendidikanController::class, 'get_all']);
                Route::post('{id}', [PendidikanController::class, 'show']);
                Route::put('edit/{id}', [PendidikanController::class, 'update']);
                Route::delete('delete/{id}', [PendidikanController::class, 'destroy']);
                Route::put('active/{id}', [PendidikanController::class, 'active']);
            });

            Route::prefix('gaji')->group(function () {
                Route::post('/', [GajiController::class, 'get_data']);
                Route::post('add', [GajiController::class, 'store']);
                Route::get('/all', [GajiController::class, 'get_all']);
                Route::post('{id}', [GajiController::class, 'show']);
                Route::put('edit/{id}', [GajiController::class, 'update']);
                Route::delete('delete/{id}', [GajiController::class, 'destroy']);
                Route::put('active/{id}', [GajiController::class, 'active']);
            });

            Route::prefix('status')->group(function () {
                Route::post('/', [StatusSantriController::class, 'get_data']);
                Route::post('add', [StatusSantriController::class, 'store']);
                Route::get('/all', [StatusSantriController::class, 'get_all']);
                Route::post('{id}', [StatusSantriController::class, 'show']);
                Route::put('edit/{id}', [StatusSantriController::class, 'update']);
                Route::delete('delete/{id}', [StatusSantriController::class, 'destroy']);
                Route::put('active/{id}', [StatusSantriController::class, 'active']);
            });
        });

        Route::prefix('santri')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('/add', [SantriController::class, 'create']);
            Route::get('/get', [SantriController::class, 'get_list']);
            Route::get('/get/{id}', [SantriController::class, 'get_by_id']);

            Route::post('/add', [SantriController::class, 'store']);
            Route::put('/{id}', [SantriController::class, 'update']);
            Route::delete('/delete/{id}', [SantriController::class, 'destroy']);
        });

        Route::prefix('santri')->middleware('kontrolAkses:admin|yayasan')->group(function () {
            Route::get('/', [SantriController::class, 'index']);
            Route::post('data', [SantriController::class, 'get_data']);
            Route::get('/{id}', [SantriController::class, 'show']);
        });

        Route::prefix('alumni')->middleware('kontrolAkses:admin|yayasan')->group(function () {
            Route::get('/', [AlumniController::class, 'index']);
            Route::post('data', [AlumniController::class, 'get_data']);
            Route::get('{id}', [AlumniController::class, 'show']);
        });

        Route::prefix('alumni')->middleware('kontrolAkses:admin')->group(function () {
            Route::post('add', [AlumniController::class, 'store']);
            Route::get('get/{id}', [AlumniController::class, 'get_by_id']);
            Route::put('{id}', [AlumniController::class, 'update']);
            Route::delete('{id}', [AlumniController::class, 'destroy']);
        });
    });

    Route::prefix('akademik')->group(function () {
        Route::prefix('kelas')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('/', [KelasController::class, 'index']);
            Route::post('data', [KelasController::class, 'get_data']);
            Route::get('list', [KelasController::class, 'get_list']);
            Route::post('add', [KelasController::class, 'store']);
            Route::delete('delete/{id}', [KelasController::class, 'destroy']);
            Route::post('{id}', [KelasController::class, 'show']);
            Route::put('edit/{id}', [KelasController::class, 'update']);
        });

        Route::prefix('mapel')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('', [MapelController::class, 'index']);
            Route::get('list', [MapelController::class, 'get_list']);
            Route::post('', [MapelController::class, 'datatable']);
            Route::post('add', [MapelController::class, 'store']);
            Route::get('{id}', [MapelController::class, 'show']);
            Route::put('{id}', [MapelController::class, 'update']);
            Route::delete('{id}', [MapelController::class, 'destroy']);
        });

        Route::prefix('pengajar')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('', [PengajarController::class, 'index']);
            Route::get('list', [PengajarController::class, 'get_list']);
            Route::post('', [PengajarController::class, 'datatable']);
            Route::post('add', [PengajarController::class, 'store']);
            Route::get('{id}', [PengajarController::class, 'show']);
            Route::put('{id}', [PengajarController::class, 'update']);
            Route::delete('{id}', [PengajarController::class, 'destroy']);
        });

        Route::prefix('jadwal')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('', [JadwalController::class, 'index']);
            Route::post('', [JadwalController::class, 'datatable']);
            Route::post('add', [JadwalController::class, 'store']);
            Route::get('{id}', [JadwalController::class, 'show']);
            Route::put('{id}', [JadwalController::class, 'update']);
            Route::delete('{id}', [JadwalController::class, 'destroy']);
        });

        Route::prefix('presensi')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('', [PresensiController::class, 'index']);
            Route::post('', [PresensiController::class, 'datatable']);
            Route::post('add', [PresensiController::class, 'store']);
            Route::get('{id}', [PresensiController::class, 'show']);
            // Route::put('{id}', [PresensiController::class, 'update']);
            Route::delete('{id}', [PresensiController::class, 'destroy']);
        });

        Route::prefix('nilai')->middleware('kontrolAkses:admin')->group(function () {
            Route::get('', [NilaiController::class, 'index']);
            Route::post('', [NilaiController::class, 'datatable']);
            Route::prefix('tambah')->group(function () {
                Route::get('', [NilaiController::class, 'create']);
                Route::post('', [NilaiController::class, 'store']);
            });
            Route::get('{id}', [NilaiController::class, 'show']);
            Route::delete('{id}', [NilaiController::class, 'destroy']);
            Route::put('{id}', [NilaiController::class, 'update']);
        });
    });

    Route::prefix('user')->middleware('kontrolAkses:admin')->group(function () {
        Route::post('admin/checkSantriEmail', [UserController::class, 'checkSantriEmail'])->name('admin.checkSantriEmail');
        Route::get('/', [UserController::class, 'index']);
        Route::get('/santri-email', [UserController::class, 'santri'])->name('user.email');
        Route::post('data', [UserController::class, 'get_data']);
        Route::post('add', [UserController::class, 'store']);
        Route::delete('delete/{id}', [UserController::class, 'destroy']);
        Route::get('{id}', [UserController::class, 'show']);
        Route::put('edit/{id}', [UserController::class, 'update']);
        Route::put('active/{id}', [UserController::class, 'active']);
    });

    Route::prefix('jadwal')->middleware('kontrolAkses:santri')->group(function () {
        Route::get('', [JadwalController::class, 'santri_index']);
    });

    Route::prefix('nilai')->middleware('kontrolAkses:santri')->group(function () {
        Route::get('', [NilaiController::class, 'santri_index']);
    });
});


Route::get('/', [DashboardController::class, 'index']);
Route::get('/stats', [DashboardController::class, 'stats_santri']);
Route::prefix('/error')->group(function () {
    Route::get('/404', function () {
        return view('pages.error.404');
    });
    Route::get('/403', function () {
        return view('pages.error.403');
    });
    Route::get('/500', function () {
        return view('pages.error.500');
    });
    Route::get('/503', function () {
        return view('pages.error.503');
    });
});
