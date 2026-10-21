<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PertanyaanController;

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