<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PeternakController;
use App\Http\Controllers\PotensiDesaController;
use App\Http\Controllers\PublicViewController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\SuratDesaController;
use Illuminate\Support\Facades\Route;

//SECTION - USER 
Route::get('/', [PublicViewController::class, 'index'])->name('dashboard');
Route::prefix('user')->group(function () {
    Route::get('/profile', [PublicViewController::class, 'indexProfileDesa'])->name('user.profile');
    Route::get('/potensidesa', [PublicViewController::class, 'indexPotensiDesa'])->name('user.potensidesa');
    Route::get('/potensi-desa/{id}', [PublicViewController::class, 'show_potensidesa'])->name('user.potensidesa.show');
    Route::get('/informasi', [PublicViewController::class, 'indexInformasi'])->name('user.informasi');
    Route::get('/informasi/{id}', [PublicViewController::class, 'show_informasi'])->name('user.informasi.show');
    Route::get('/organisasi', [PublicViewController::class, 'indexStrukturOrganisasi'])->name('user.organisasi');
});

Route::prefix('user')->group(function () {
    Route::get('/surat', [SuratDesaController::class, 'create'])->name('user.surat.create');
    Route::post('/surat', [SuratDesaController::class, 'store'])->name('user.surat.store');
    Route::get('/dokumen/{id}', [SuratDesaController::class, 'getFields'])->name('user.dokumen.fields');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//SECTION - ADMIN\
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    //SECTION - Profile Desa 
    Route::controller(DesaController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/{id}', 'update')->name('update');
    });

    //SECTION - Struktur Organisasi
    Route::controller(StrukturOrganisasiController::class)->prefix('struktur-organisasi')->name('struktur-organisasi.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}/updatestrukturanggota', 'updateStrukturOrganisasi')->name('updateStrukturOrganisasi');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::put('/{id}', 'update')->name('update');
    });

    //SECTION - Informasi
    Route::controller(InformasiController::class)->prefix('informasi')->name('informasi.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    //SECTION - Potensi Desa
    Route::controller(PotensiDesaController::class)->prefix('potensi-desa')->name('potensi-desa.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    Route::controller(SuratDesaController::class)->prefix('surat-desa')->name('surat-desa.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/gambar-surat/{filename}', 'showImage')->name('gambar.show');
        Route::get('/{id}', 'show')->name('show');
        Route::patch('/{id}/update-status', 'updateStatus')->name('update-status');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('peternak')->controller(PeternakController::class)->name('peternak.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/export', 'export')->name('export');
    });
});
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/callback/google', [SocialiteController::class, 'handleGoogleCallback']);