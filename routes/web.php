<?php

use App\Http\Controllers\Admin\ItemProdukController;
use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\ForgotPasswordController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\KeanggotaanController;
use App\Http\Controllers\Pages\KontakController;
use App\Http\Controllers\Pages\LmsAppController;
use App\Http\Controllers\Pages\MemberAreaController;
use App\Http\Controllers\Pages\NewsController;
use App\Http\Controllers\Pages\ProdukController;
use App\Http\Controllers\Pages\PublikasiController;
use App\Http\Controllers\Pages\ResetPasswordController;
use App\Http\Controllers\Pages\SejawatAppController;
use App\Http\Controllers\Pages\SelengkapnyaController;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

// ROUTE MAIN PAGE
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/programkerja-selengkapnya/{id}', [HomeController::class, 'programkerjaselengkapnya'])->name('home.prokerselengkapnya');
Route::get('/publikasi', [PublikasiController::class, 'index'])->name('publikasi.index');
Route::get('/keanggotaan', [KeanggotaanController::class, 'index'])->name('keanggotaan.index');
Route::get('/lms-app', [LmsAppController::class, 'show'])->name('lmsApp.show');
Route::get('/sejawat-app', [SejawatAppController::class, 'index'])->name('sejawatApp.index');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::get('/selengkapnya', [SelengkapnyaController::class, 'index'])->name('selengkapnya.index');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

// ROUTE ABOUT PAGE
Route::get('/about/history', [AboutController::class, 'history'])->name('about.history');
Route::get('/about/visi-dan-misi', [AboutController::class, 'visiDanMisi'])->name('about.visiDanMisi');
Route::get('/about/program-kerja', [AboutController::class, 'programKerja'])->name('about.programKerja');
Route::get('/about/struktur-organisasi', [AboutController::class, 'strukturOrganisasi'])->name('about.strukturOrganisasi');
Route::get('/about/anggaran-dasar', [AboutController::class, 'anggaranDasar'])->name('about.anggaranDasar');

// ROUTE PRODUK PAGE
Route::get('/produk', [ItemProdukController::class, 'index'])->name('produk');
Route::get('/produk/komite-standar', [ProdukController::class, 'komiteStandar'])->name('produk.komite-standar');
Route::get('/produk/komite-telaah-sejawat', [ProdukController::class, 'komiteTelaah'])->name('produk.komite-telaah-sejawat');
Route::get('/produk/komite-kode-etik', [ProdukController::class, 'komiteKodeEtik'])->name('produk.komite-kode-etik');
Route::get('/produk/komite-pengembangan-profesi', [ProdukController::class, 'komiteProfesi'])->name('produk.komite-pengembangan-profesi');

// ROUTE REGISTRASI
Route::name('memberArea.')->prefix('memberArea')->controller(MemberAreaController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/verification', 'verification')->name('verification');
    Route::post('/check-user', 'checkDataUser')->name('check-user');
    Route::post('/registrasi-aktifasi', 'registrasiAktifasi')->name('registrasi-aktifasi');
    Route::post('/registrasi-luarbiasa', 'registrasiLuarBiasa')->name('registrasi-luarbiasa');
    Route::post('/setup-password', 'setupPassword')->name('setup-password');
});

// Content
Route::get('content/{slug}', [NewsController::class, 'show'])->name('news.show');

// Komentar
Route::name('news.comments.')->prefix('comments')->controller(NewsController::class)->group(function () {
    Route::get('/{id}', 'comment')->name('get');
    Route::post('/', 'postComment')->name('post');
});

// Forgot password
Route::prefix('forgot-password')->name('memberArea.forgot-password.')->controller(ForgotPasswordController::class)->group(function(){
    Route::get('/', 'forgotpassword')->name('index');
    Route::post('/', 'sendResetLinkEmail')->name('action');
   
});

Route::prefix('reset-password')->name('memberArea.reset-password.')->controller(ResetPasswordController::class)->group(function(){
    Route::get('/', 'resetPassword')->name('index');
    Route::post('/{token}', 'resetPasswordAction')->name('action');
});

// Additional get gallery
Route::get('/allGallery', [HomeController::class, 'getAllGallery'])->name('get.all.gallery');
Route::get('/categoryGallery/{id}', [HomeController::class, 'getCategoryGallery'])->name('get.category.gallery');