<?php

use App\Http\Controllers\admin\AdBannerController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BiayaKeanggotaanController;
use App\Http\Controllers\Admin\CategoryOnGaleriController;
use App\Http\Controllers\Admin\CMS\ElmsController;
use App\Http\Controllers\Admin\CMS\KontakController;
use App\Http\Controllers\Admin\CMS\ProgramKerjaNewController;
use App\Http\Controllers\Admin\CMS\SejawatController;
use App\Http\Controllers\Admin\CMS\StrukturOrganisasiController;
use App\Http\Controllers\Admin\CMS\VisiMisiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterIconController;
use App\Http\Controllers\Admin\FungsiUnitKerjaController;
use App\Http\Controllers\Admin\GaleriKategoriController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\SyaratPendaftaranController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VerifikasiKeanggotaanController;
use App\Http\Controllers\Admin\VerifikasiPembayaranController;
use App\Http\Controllers\Dashboard\Page\AboutHistoryController;
use App\Http\Controllers\Dashboard\Page\AnggranDasarController;
use App\Http\Controllers\Dashboard\Page\PertanyaanController;
// use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Dashboard\Page\ProgramKerjaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/panel', '/panel/login');
// ROUTE LOGIN
Route::prefix('panel/login')->middleware('guest')->controller(LoginController::class)->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('loginAction');
});

// ROUTE AUTH PAGE
Route::prefix('panel')->middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.admin.view');
    Route::get('/change-profile', [UserController::class, 'changeProfile'])->name('user-management.user.change-profile');

    Route::name('profile.')->prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/change-password', 'changePassword')->name('change-password');
        Route::get('/aktifasi-keanggotaan', 'aktifasiKeanggotaan')->name('aktifasi-keanggotaan');

        Route::post('/change-profile', 'changeProfile')->name('change-profile');
        Route::post('/change-password', 'changePasswordAction')->name('change-password-action');
        Route::post('/aktifasi-keanggotaan', 'aktifasiKeanggotaanAction')->name('aktifasi-keanggotaan-action');
    });

    Route::prefix('cms')->group(function () {
        Route::name('cms.news.')->prefix('news')->controller(NewsController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });

        Route::name('cms.kontak.')->prefix('kontak')->controller(KontakController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'actions')->name('actions');
        });

        Route::name('cms.about-history.')->prefix('about-history')->controller(AboutHistoryController::class)->group(function () {
            Route::get('/', 'indexNew')->name('index');
            Route::post('/', 'actions')->name('actions');
        });

        Route::name('cms.sejawat.')->prefix('sejawat')->controller(SejawatController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'actions')->name('actions');
        });

        Route::name('cms.media-social.')->prefix('media-social')->controller(FooterIconController::class)->group(function () {
            Route::get('/', 'indexNew')->name('index');
            Route::post('/', 'actions')->name('actions');
        });

        Route::name('cms.program-kerja.')->prefix('program-kerja')->controller(ProgramKerjaNewController::class)->group(function () {
            Route::get('/', 'indexNew')->name('indexNew');
            Route::post('/', 'actions')->name('actions');
        });
    });

    Route::prefix('user-management')->group(function () {
        Route::name('user-management.user.')->prefix('user')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/create/{type}', 'create')->whereIn('type', ['admin', 'anggota-kehormatan'])->name('create');
            Route::get('/view/{type}', 'getView')->name('view');
            Route::post('/{type}', 'store')->whereIn('type', ['admin', 'anggota-kehormatan'])->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });

        Route::name('user-management.role.')->prefix('role')->controller(RoleController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });

        Route::name('user-management.role-permission.')->prefix('role-permission')->controller(RolePermissionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'view')->name('view');
            Route::post('/', 'store')->name('store');
        });
    });

    Route::prefix('verifikasi')->group(function () {
        Route::name('verifikasi.keanggotaan.')->prefix('keanggotaan')->controller(VerifikasiKeanggotaanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/verification', 'verification')->name('verification');
            Route::get('/view/{type}', 'getView')->name('view');
            Route::get('/{id}', 'show')->name('show');
            Route::post('/{id}', 'changeStatusRegistrasi')->name('decision');
        });

        Route::name('verifikasi.pembayaran.')->prefix('pembayaran')->controller(VerifikasiPembayaranController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/view/{type}', 'getView')->name('view');
            Route::get('/{id}', 'show')->name('show');
            Route::post('/{id}', 'changeStatus')->name('decision');
        });
    });

    Route::prefix('setting')->group(function () {
        Route::name('setting.biaya-keanggotaan.')->prefix('biaya-keanggotaan')->controller(BiayaKeanggotaanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });

        Route::name('setting.syarat-pendaftaran.')->prefix('syarat-pendaftaran')->controller(SyaratPendaftaranController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{parent_id?}', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::match(['post', 'put'], '/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });

    });
    Route::prefix('CMS')->group(function () {
        Route::name('CMS.visi-misi.')->prefix('visi-misi')->controller(VisiMisiController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'actions')->name('actions');
            // Route::get('/', 'index')->name('index');
            // Route::get('/create', 'create')->name('create');
            // Route::get('/edit/{id}', 'edit')->name('edit');
            // Route::get('/view', 'getView')->name('view');
            // Route::post('/', 'store')->name('store');
            // Route::put('/{id}', 'update')->name('update');
            // Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('program-kerja')->group(function () {
        Route::name('program-kerja.')->controller(ProgramKerjaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('anggaran-dasar')->group(function () {
        Route::name('anggaran-dasar.')->controller(AnggranDasarController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/actions', 'actions')->name('actions');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });
    Route::prefix('pertanyaan')->group(function () {
        Route::name('pertanyaan.')->controller(PertanyaanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('CMS')->group(function () {
        Route::name('CMS.banner.')->prefix('banner')->controller(BannerController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
            Route::post('/actions', 'actions')->name('actions');
        });
    });

    // Route::prefix('CMS')->group(function(){
    //     Route::name('CMS.icon-footer.')->prefix('icon-footer')->controller(FooterIconController::class)->group(function(){
    //         Route::get('/', 'index')->name('index');
    //         Route::get('/create', 'create')->name('create');
    //         Route::get('/edit/{id}', 'edit')->name('edit');
    //         Route::get('/view', 'getView')->name('view');
    //         Route::post('/', 'store')->name('store');
    //         Route::put('/{id}', 'update')->name('update');
    //         Route::delete('/{id}', 'destroy')->name('delete');
    //     });
    // });

    Route::prefix('CMS')->group(function () {
        Route::name('CMS.fungsi-unit-kerja.')->prefix('fungsi-unit-kerja')->controller(FungsiUnitKerjaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('CMS')->group(function () {
        Route::name('CMS.galeri-kategori.')->prefix('galeri-kategori')->controller(GaleriKategoriController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('cms')->group(function () {
        Route::name('cms.sponsor.')->prefix('sponsor')->controller(SponsorController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('cms')->group(function () {
        Route::name('cms.iklan-banner.')->prefix('iklan-banner')->controller(AdBannerController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('CMS')->group(function () {
        Route::name('CMS.struktur-organisasi.')->prefix('struktur-organisasi')->controller(StrukturOrganisasiController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'actions')->name('actions');
            // Route::get('/create', 'create')->name('create');
            // Route::get('/edit/{id}', 'edit')->name('edit');
            // Route::get('/view', 'getView')->name('view');
            // Route::post('/', 'store')->name('store');
            // Route::put('/{id}', 'update')->name('update');
            // Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('CMS')->group(function () {
        Route::name('CMS.lms-app.')->prefix('lms-app')->controller(ElmsController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'actions')->name('actions');
            // Route::get('/create', 'create')->name('create');
            // Route::get('/edit/{id}', 'edit')->name('edit');
            // Route::get('/view', 'getView')->name('view');
            // Route::post('/', 'store')->name('store');
            // Route::put('/{id}', 'update')->name('update');
            // Route::delete('/{id}', 'destroy')->name('delete');
        });
    });

    Route::prefix('setting')->group(function () {
        Route::name('setting.category-on-galeri.')->prefix('category-on-galeri')->controller(CategoryOnGaleriController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view', 'getView')->name('view');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });
});
