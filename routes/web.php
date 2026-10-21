<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PertanyaanController;

// ROUTE KATEGORI
Route::get('/daftar-kategori', [KategoriController::class, 'tampil']);
Route::get('/tambah-kategori', [KategoriController::class, 'create']);
Route::post('/simpan-kategori', [KategoriController::class, 'simpan']);
Route::get('/update-kategori/{kategori}', [KategoriController::class, 'update']);

// ROUTE PERTANYAAN
Route::get('/daftar-pertanyaan', [PertanyaanController::class, 'tampil']);
Route::get('/tambah-pertanyaan', [PertanyaanController::class, 'create']);
Route::post('/simpan-kategori', [PertanyaanController::class, "simpan"]);