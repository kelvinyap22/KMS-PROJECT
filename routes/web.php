<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\StudentFaqController;

// ROUTE KATEGORI
Route::get('/daftar-kategori', [KategoriController::class, 'tampil']);
Route::get('/tambah-kategori', [KategoriController::class, 'create']);
Route::post('/simpan-kategori', [KategoriController::class, 'simpan']);
Route::get('/ubah-kategori/{kategori}', [KategoriController::class, 'ubah']);
Route::put('/update-kategori/{kategori}', [KategoriController::class, 'update']);
Route::delete('/hapus-kategori/{kategori}', [KategoriController::class, 'delete']);

// ROUTE PERTANYAAN
Route::get('/daftar-pertanyaan', [PertanyaanController::class, 'tampil']);
Route::get('/tambah-pertanyaan', [PertanyaanController::class, 'create']);
Route::post('/simpan-pertanyaan', [PertanyaanController::class, "simpan"]);
Route::get('/ubah-pertanyaan/{pertanyaan}', [PertanyaanController::class, 'ubah']);
Route::put('/update-pertanyaan/{pertanyaan}', [PertanyaanController::class, 'update']);
Route::delete('/hapus-pertanyaan/{pertanyaan}', [PertanyaanController::class, 'delete']);
Route::post('/kirim-pertanyaan/{pertanyaan}', [PertanyaanController::class,'kirim']);

// ==============================
// LOGIN MAHASISWA
// ==============================

Route::get('/login-mahasiswa', [MahasiswaAuthController::class, 'showLogin'])
    ->name('mahasiswa.login.form');

Route::post('/login-mahasiswa', [MahasiswaAuthController::class, 'login'])
    ->name('student.verify-nrp');

// halaman utama FAQ mahasiswa dan saran pertanyaan mahasiswa
Route::middleware(['mahasiswa'])->group(function () {
Route::get('/kms', [StudentFaqController::class, 'index'])
        ->name('student.kms');
Route::post('/saran-pertanyaan', [StudentFaqController::class, 'storeSuggestion'])
        ->name('student.store-suggestion');
Route::post('/logout-mahasiswa', [MahasiswaAuthController::class, 'logout'])
        ->name('mahasiswa.logout');

});