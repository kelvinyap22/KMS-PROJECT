<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\FAQController;

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


// ROUTE Halaman FAQ
Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');

// Route untuk memproses form saran pertanyaan dari mahasiswa
Route::post('/faq/suggest', [FAQController::class, 'storeSuggestion'])->name('faq.suggest');