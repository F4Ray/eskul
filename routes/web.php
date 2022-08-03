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
    return view('welcome');
});

Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:siswa'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::resource('master_guru', MasterGuruController::class);
    Route::resource('absensi_guru', MasterGuruController::class);
    Route::resource('master_mapel', MasterMapelController::class);
    Route::resource('master_siswa', MasterSiswaController::class);
    Route::resource('master_kelas', MasterKelasController::class);
    Route::resource('master_jadwal_pelajaran', MasterJadwalPelajaranController::class);
    Route::resource('absensi_guru', AbsensiGuruController::class);
    Route::resource('absensi_siswa', AbsensiSiswaController::class);

    Route::group(['as' => 'master_jadwal_pelajaran.'], function () {
        Route::post('ajax_kelas', [MasterJadwalPelajaranController::class, 'ajaxKelas'])->name('ajax_kelas');
        Route::post('ajax_guru', [MasterJadwalPelajaranController::class, 'ajaxGuru'])->name('ajax_guru');
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
});
