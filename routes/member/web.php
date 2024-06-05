<?php

use App\Http\Controllers\Dashboard\Page\AnggranDasarController;
use App\Http\Controllers\Member\AppController;
use App\Http\Controllers\Member\ChangeProfileController;
use App\Http\Controllers\Member\DashboardMemberController;
use App\Http\Controllers\Member\LoginMemberController;
use App\Http\Controllers\Member\PembayaranKeanggotaanController;
use App\Http\Controllers\Member\RiwayatJabatanController;
use App\Http\Controllers\Member\RiwayatPangkatController;
use App\Http\Controllers\Member\RiwayatPekerjaanController;
use App\Http\Controllers\Member\RiwayatPendidikanController;
use App\Http\Controllers\Member\TransTiketController;
use Illuminate\Support\Facades\Route;

// ROUTE LOGIN
Route::prefix('member/login')->middleware('guest')->group(function () {
    Route::post('/', [LoginMemberController::class, 'login'])->name('memberLoginAction');
});

// ROUTE AUTH PAGE
Route::prefix('member')->middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginMemberController::class, 'logout'])->name('member.auth.logout');
    Route::get('/', [DashboardMemberController::class, 'index'])->name('dashboard.view');
    Route::get('/resume', [DashboardMemberController::class, 'resume'])->name('member.resume');
    Route::get('/pembelian', [DashboardMemberController::class, 'pembelian'])->name('member.pembelian');
    Route::get('/tagihan', [DashboardMemberController::class, 'tagihan'])->name('member.tagihan');
    Route::post('/actions', [DashboardMemberController::class, 'actions'])->name('member.actions');

    Route::get('/app', [AppController::class, 'index'])->name('member.app');

    // Tiket routes
    Route::get('/tiket', [TransTiketController::class, 'index'])->name('member.tiket');
    Route::get('tiket/datatables', [TransTiketController::class, 'datatables'])->name('datatables');
    Route::get('/tiket/view', [TransTiketController::class, 'getView'])->name('tiket.getView');
    Route::get('/tiket/create', [TransTiketController::class, 'create'])->name('tiket.create');
    Route::get('/tiket/edit/{id}', [TransTiketController::class, 'edit'])->name('tiket.edit');
    Route::get('/tiket/view', [TransTiketController::class, 'getView'])->name('tiket.view');
    Route::post('/tiket', [TransTiketController::class, 'store'])->name('tiket.store');
    Route::put('/tiket/{id}', [TransTiketController::class, 'update'])->name('tiket.update');
    Route::delete('/tiket/{id}', [TransTiketController::class, 'destroy'])->name('tiket.delete');

    // Tagihan
    Route::get('/tagihan', [PembayaranKeanggotaanController::class, 'index'])->name('member.tagihan');
    Route::get('tagihan/datatables', [PembayaranKeanggotaanController::class, 'datatables'])->name('datatables');
    Route::get('/tagihan/view', [PembayaranKeanggotaanController::class, 'getView'])->name('tagihan.getView');
    Route::get('/tagihan/create', [PembayaranKeanggotaanController::class, 'create'])->name('tagihan.create');
    Route::get('/tagihan/edit/{id}', [PembayaranKeanggotaanController::class, 'edit'])->name('tagihan.edit');
    Route::get('/tagihan/view', [PembayaranKeanggotaanController::class, 'getView'])->name('tagihan.view');
    Route::post('/tagihan', [PembayaranKeanggotaanController::class, 'store'])->name('tagihan.store');
    Route::put('/tagihan/{id}', [PembayaranKeanggotaanController::class, 'update'])->name('tagihan.update');
    Route::delete('/tagihan/{id}', [PembayaranKeanggotaanController::class, 'destroy'])->name('tagihan.delete');
    // Anggaran Dasar routes
    Route::prefix('anggaran-dasar')->name('anggaran-dasar.')->group(function () {
        Route::get('/', [AnggranDasarController::class, 'index'])->name('index');
        Route::get('/create', [AnggranDasarController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [AnggranDasarController::class, 'edit'])->name('edit');
        Route::get('/view', [AnggranDasarController::class, 'getView'])->name('view');
        Route::post('/', [AnggranDasarController::class, 'store'])->name('store');
        Route::put('/{id}', [AnggranDasarController::class, 'update'])->name('update');
        Route::delete('/{id}', [AnggranDasarController::class, 'destroy'])->name('delete');
    });

    // Change Profile
    Route::prefix('change-profile')->name('member.change-profile.')->controller(ChangeProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'changeProfile')->name('action');
        Route::post('/kotaKab', 'kotaKab')->name('kotaKab');
        Route::post('/getDataFromUNIT', 'getDataFromUNIT')->name('getDataFromUNIT');
    });

    // Change Password
    Route::prefix('change-password')->name('member.change-password.')->controller(ChangeProfileController::class)->group(function () {
        Route::get('/', 'changePassword')->name('index');
        Route::post('/', 'changePasswordAction')->name('action');
    });

    // Riwayat Jabatan
    Route::prefix('riwayat-jabatan')->name('member.riwayat-jabatan.')->controller(RiwayatJabatanController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('delete');
    });

    // Riwayat Pangkat
    Route::prefix('riwayat-pangkat')->name('member.riwayat-pangkat.')->controller(RiwayatPangkatController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('delete');
    });

    // Riwayat Jabatan
    Route::prefix('riwayat-pendidikan')->name('member.riwayat-pendidikan.')->controller(RiwayatPendidikanController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('delete');
    });

    // Riwayat Pangkat
    Route::prefix('riwayat-pekerjaan')->name('member.riwayat-pekerjaan.')->controller(RiwayatPekerjaanController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('delete');
    });
});
