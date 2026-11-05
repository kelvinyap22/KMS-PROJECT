
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\StudentFaqController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\DataEntryController;
use App\Http\Controllers\ValidatorController;
use App\Http\Controllers\SuperAdminController;


// =================================
// ROUTE KATEGORI
// =================================

Route::get('/daftar-kategori', [KategoriController::class, 'tampil']);
Route::get('/tambah-kategori', [KategoriController::class, 'create']);
Route::post('/simpan-kategori', [KategoriController::class, 'simpan']);
Route::get('/ubah-kategori/{kategori}', [KategoriController::class, 'ubah']);
Route::put('/update-kategori/{kategori}', [KategoriController::class, 'update']);
Route::delete('/hapus-kategori/{kategori}', [KategoriController::class, 'delete']);


// =================================
// ROUTE PERTANYAAN
// =================================

Route::get('/daftar-pertanyaan', [PertanyaanController::class, 'tampil']);
Route::get('/tambah-pertanyaan', [PertanyaanController::class, 'create']);
Route::post('/simpan-pertanyaan', [PertanyaanController::class, 'simpan']);
Route::get('/ubah-pertanyaan/{pertanyaan}', [PertanyaanController::class, 'ubah']);
Route::put('/update-pertanyaan/{pertanyaan}', [PertanyaanController::class, 'update']);
Route::delete('/hapus-pertanyaan/{pertanyaan}', [PertanyaanController::class, 'delete']);
Route::post('/kirim-pertanyaan/{pertanyaan}', [PertanyaanController::class, 'kirim']);


// =================================
// LOGIN MAHASISWA
// =================================

Route::get('/login-mahasiswa', [MahasiswaAuthController::class, 'showLogin'])
    ->name('mahasiswa.login.form');

Route::post('/login-mahasiswa', [MahasiswaAuthController::class, 'login'])
    ->name('student.verify-nrp');


// =================================
// HALAMAN MAHASISWA
// =================================

Route::middleware(['mahasiswa'])->group(function () {

    Route::get('/kms', [StudentFaqController::class, 'index'])
        ->name('student.kms');

    Route::post('/saran-pertanyaan', [StudentFaqController::class, 'storeSuggestion'])
        ->name('student.store-suggestion');

    Route::post('/logout-mahasiswa', [MahasiswaAuthController::class, 'logout'])
        ->name('mahasiswa.logout');

});


// =================================
// LOGIN STAFF / USERS
// =================================

Route::post('/staff/login', [UserAuthController::class, 'login'])
    ->name('staff.login');

Route::post('/staff/logout', [UserAuthController::class, 'logout'])
    ->name('staff.logout');


// =================================
// DASHBOARD DATA ENTRY
// =================================

Route::prefix('dataentry')
    ->name('dataentry.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/index', [DataEntryController::class, 'index'])
            ->name('index');

        Route::post('/simpan-pertanyaan', [DataEntryController::class, 'store'])
            ->name('store');

        Route::put('/update-pertanyaan/{id}', [DataEntryController::class, 'update'])
            ->name('update');

        Route::delete('/hapus-pertanyaan/{id}', [DataEntryController::class, 'destroy'])
            ->name('destroy');

        Route::post('/kirim-pertanyaan/{id}', [DataEntryController::class, 'kirim'])
            ->name('kirim');
        Route::put('/saran/{id}/status', [DataEntryController::class, 'updateStatusSaran'])
        ->name('saran.update-status');
    });


// =================================
// DASHBOARD VALIDATOR
// =================================

Route::prefix('validator')
    ->name('validator.')
    ->middleware('auth')
    ->group(function () {

        // Daftar pertanyaan yang menunggu validasi
        Route::get('/dashboard', [ValidatorController::class, 'index'])
            ->name('dashboard');

        // Menyetujui pertanyaan
        Route::post('/pertanyaan/{pertanyaan}/approve', [ValidatorController::class, 'approve'])
            ->name('approve');

        // Menolak pertanyaan
        Route::post('/pertanyaan/{pertanyaan}/reject', [ValidatorController::class, 'reject'])
            ->name('reject');
        

    });

// =================================
// DASHBOARD SUPER ADMIN
// =================================
Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware('auth')
    ->group(function () {

        // Dashboard View
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');

        // CRUD Users
        Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{id}', [SuperAdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [SuperAdminController::class, 'destroyUser'])->name('users.destroy');

        // CRUD Kategori
        Route::post('/kategori', [SuperAdminController::class, 'storeKategori'])->name('kategori.store');
        Route::put('/kategori/{id}', [SuperAdminController::class, 'updateKategori'])->name('kategori.update');
        Route::delete('/kategori/{id}', [SuperAdminController::class, 'destroyKategori'])->name('kategori.destroy');

        // CRUD Pertanyaan FAQ
        Route::put('/pertanyaan/{id}', [SuperAdminController::class, 'updatePertanyaan'])->name('pertanyaan.update');
        Route::delete('/pertanyaan/{id}', [SuperAdminController::class, 'destroyPertanyaan'])->name('pertanyaan.destroy');

        // Update Saran Mahasiswa
        Route::put('/saran/{id}', [SuperAdminController::class, 'updateSaran'])->name('saran.update');
        
    });