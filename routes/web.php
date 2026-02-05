<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProgramDonasiController;
use App\Http\Controllers\Admin\DonasiController as AdminDonasiController;
use App\Http\Controllers\Admin\UsulanProgramController as AdminUsulanController;
use App\Http\Controllers\Admin\KontenKegiatanController;
use App\Http\Controllers\Admin\KategoriProgramController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\UsulanProgramController as UserUsulanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Programs
Route::get('/program', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/program/{id}', [ProgramController::class, 'show'])->name('programs.show');

// Donations
Route::get('/donasi/{program}', [DonasiController::class, 'create'])->name('donasi.create');
Route::post('/donasi', [DonasiController::class, 'store'])->name('donasi.store');
Route::get('/donasi/sukses/{kode}', [DonasiController::class, 'success'])->name('donasi.success');
Route::get('/lacak-donasi', [DonasiController::class, 'track'])->name('donasi.track');

// Activities
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Programs
        Route::get('/programs', [ProgramDonasiController::class, 'index'])->name('programs.index');
        Route::get('/programs/create', [ProgramDonasiController::class, 'create'])->name('programs.create');
        Route::post('/programs', [ProgramDonasiController::class, 'store'])->name('programs.store');
        Route::get('/programs/{id}/edit', [ProgramDonasiController::class, 'edit'])->name('programs.edit');
        Route::put('/programs/{id}', [ProgramDonasiController::class, 'update'])->name('programs.update');
        Route::delete('/programs/{id}', [ProgramDonasiController::class, 'destroy'])->name('programs.destroy');
        Route::get('/programs/{id}/progress', [ProgramDonasiController::class, 'showProgress'])->name('programs.progress');
        Route::post('/programs/{id}/progress', [ProgramDonasiController::class, 'storeProgress'])->name('programs.progress.store');

        // Donations
        Route::get('/donasi', [AdminDonasiController::class, 'index'])->name('donasi.index');
        Route::get('/donasi/{id}', [AdminDonasiController::class, 'show'])->name('donasi.show');
        Route::post('/donasi/{id}/approve', [AdminDonasiController::class, 'approve'])->name('donasi.approve');
        Route::post('/donasi/{id}/reject', [AdminDonasiController::class, 'reject'])->name('donasi.reject');

        // Proposals
        Route::get('/usulan', [AdminUsulanController::class, 'index'])->name('usulan.index');
        Route::get('/usulan/{id}', [AdminUsulanController::class, 'show'])->name('usulan.show');
        Route::post('/usulan/{id}/approve', [AdminUsulanController::class, 'approve'])->name('usulan.approve');
        Route::post('/usulan/{id}/reject', [AdminUsulanController::class, 'reject'])->name('usulan.reject');
        Route::post('/usulan/{id}/convert', [AdminUsulanController::class, 'convertToProgram'])->name('usulan.convert');

        // Content
        Route::get('/konten', [KontenKegiatanController::class, 'index'])->name('konten.index');
        Route::get('/konten/create', [KontenKegiatanController::class, 'create'])->name('konten.create');
        Route::post('/konten', [KontenKegiatanController::class, 'store'])->name('konten.store');
        Route::get('/konten/{id}/edit', [KontenKegiatanController::class, 'edit'])->name('konten.edit');
        Route::put('/konten/{id}', [KontenKegiatanController::class, 'update'])->name('konten.update');
        Route::delete('/konten/{id}', [KontenKegiatanController::class, 'destroy'])->name('konten.destroy');

        // Categories
        Route::get('/kategori', [KategoriProgramController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [KategoriProgramController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{id}', [KategoriProgramController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KategoriProgramController::class, 'destroy'])->name('kategori.destroy');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', \App\Http\Middleware\IsMasyarakat::class])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // Dashboard
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');

        // Proposals
        Route::get('/usulan', [UserUsulanController::class, 'index'])->name('usulan.index');
        Route::get('/usulan/create', [UserUsulanController::class, 'create'])->name('usulan.create');
        Route::post('/usulan', [UserUsulanController::class, 'store'])->name('usulan.store');
        Route::get('/usulan/{id}', [UserUsulanController::class, 'show'])->name('usulan.show');
    });

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
