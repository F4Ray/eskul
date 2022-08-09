<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterGuruController;
use App\Http\Controllers\MasterJadwalPelajaranController;
use App\Http\Controllers\MasterKelasController;
use App\Http\Controllers\MasterMapelController;
use App\Http\Controllers\MasterSiswaController;
use App\Http\Controllers\AbsensiGuruController;
use App\Http\Controllers\AbsensiSiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NilaiSiswaController;
use App\Models\NilaiSiswa;

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

Route::get('/', function () {
    // return view('welcome');
    return view('auth.login');
    // Route::get('/', [LoginController::class, 'index']);
});

Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:siswa,admin'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::group(['as' => 'master_siswa.'], function () {
        Route::get('detailsiswa/{id}', [MasterSiswaController::class, 'show'])->name('profile');
        Route::get('detailsiswa/gantifoto/siswa/{id}', [MasterSiswaController::class, 'changePicture'])->name('gantifoto');
        Route::put('simpanfoto/siswa/{id}', [MasterSiswaController::class, 'savePicture'])->name('simpanfoto');

    });
    Route::resource('master_siswa', MasterSiswaController::class);

});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::resource('master_guru', MasterGuruController::class);
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::resource('absensi_guru', MasterGuruController::class);
    Route::resource('master_mapel', MasterMapelController::class);
    Route::resource('master_kelas', MasterKelasController::class);
    Route::resource('master_jadwal_pelajaran', MasterJadwalPelajaranController::class);
    Route::resource('absensi_guru', AbsensiGuruController::class);
    Route::resource('absensi_siswa', AbsensiSiswaController::class);

    Route::group(['as' => 'master_jadwal_pelajaran.'], function () {
        Route::post('ajax_guru', [MasterJadwalPelajaranController::class, 'ajaxGuru'])->name('ajax_guru');
        Route::post('ajax_kelas_jadwal', [MasterJadwalPelajaranController::class, 'ajaxKelas'])->name('ajax_kelas_jadwal');
    });
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin,guru'])->group(function () {

    Route::get('/guru/home', [HomeController::class, 'guruHome'])->name('guru.home');
    Route::resource('absensi_guru', AbsensiGuruController::class, ['only' => ['create', 'store', 'index']]);
    Route::resource('absensi_siswa', AbsensiSiswaController::class, ['only' => ['create', 'store', 'index','edit','update']]);
    Route::get('absensi_siswa/{id}/{date}/edit', ['as' => 'absensi_siswa.edit', 'uses' => 'App\Http\Controllers\AbsensiSiswaController@edit']);
    Route::delete('absensi_siswa/{id}/{date}', ['as' => 'absensi_siswa.destroy', 'uses' => 'App\Http\Controllers\AbsensiSiswaController@destroy']);
    Route::resource('nilai', NilaiSiswaController::class);
    // Route::post('nilai/{idSiswa}/{idJadwal}', ['as' => 'nilai.show', 'uses' => 'App\Http\Controllers\NilaiSiswaController@show']);
    Route::group(['as' => 'nilai.'], function () {
        Route::post('ajax_kelas', [NilaiSiswaController::class, 'ajaxKelas'])->name('ajax_kelas');
        // Route::post('lihat', [NilaiSiswaController::class, 'lihat'])->name('lihat');
        Route::get('lihat', [NilaiSiswaController::class, 'lihat'])->name('lihat');
        
        // Route::post('ajax_guru', [NilaiSiswaController::class, 'ajaxGuru'])->name('ajax_guru');
    });

    Route::group(['as' => 'master_guru.'], function () {
        Route::get('master_guru/gantifoto/guru/{id}', [MasterGuruController::class, 'changePicture'])->name('gantifoto');
        Route::post('simpanfoto/guru/', [MasterGuruController::class, 'savePicture'])->name('simpanfoto');
        Route::get('master_guru/{id}/ubahpassword', [MasterGuruController::class, 'showPassword'])->name('lihatpassword');
        Route::put('master_guru/ubahpassword/{id}', [MasterGuruController::class, 'changePassword'])->name('ubahpassword');
        // Route::post('ajax_guru', [NilaiSiswaController::class, 'ajaxGuru'])->name('ajax_guru');
    });

});
