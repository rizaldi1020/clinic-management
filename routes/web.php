<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ─── Auth ────────────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

Route::get('/',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ─── Dashboard per role (semua wajib login) ───────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/dokter/dashboard', [DashboardController::class, 'dokter'])
        ->middleware('role:dokter')
        ->name('dokter.dashboard');

    Route::get('/resepsionis/dashboard', [DashboardController::class, 'resepsionis'])
        ->middleware('role:resepsionis')
        ->name('resepsionis.dashboard');

    Route::get('/apoteker/dashboard', [DashboardController::class, 'apoteker'])
        ->middleware('role:apoteker')
        ->name('apoteker.dashboard');

    Route::get('/obat/dashboard', [DashboardController::class, 'obat'])
        ->middleware('role:admin,apoteker')
        ->name('obat.dashboard');
        
    Route::get('/kasir/dashboard', [DashboardController::class, 'kasir'])
        ->middleware('role:kasir')
        ->name('kasir.dashboard');

    Route::get('/pasien/dashboard', [DashboardController::class, 'pasien'])
        ->middleware('role:pasien')
        ->name('pasien.dashboard');

});

// ─── Pasien (admin + resepsionis) ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,resepsionis'])->group(function () {
    Route::resource('pasien', \App\Http\Controllers\PasienController::class);
});

// ─── Dokter (admin) ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('dokter', \App\Http\Controllers\DokterController::class);

    // Jadwal praktik (nested resource di bawah dokter)
    Route::post('dokter/{dokter}/jadwal',           [\App\Http\Controllers\JadwalDokterController::class, 'store'])->name('jadwal.store');
    Route::put('dokter/{dokter}/jadwal/{jadwal}',   [\App\Http\Controllers\JadwalDokterController::class, 'update'])->name('jadwal.update');
    Route::delete('dokter/{dokter}/jadwal/{jadwal}',[\App\Http\Controllers\JadwalDokterController::class, 'destroy'])->name('jadwal.destroy');
});

// ─── Departemen / Poli (admin) ────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('departemen', \App\Http\Controllers\DepartemenController::class);
});

// ─── Manajemen User (admin) ───────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::patch('user/{user}/toggle-status',  [\App\Http\Controllers\UserController::class, 'toggleStatus'])->name('user.toggle-status');
    Route::patch('user/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])->name('user.reset-password');
});

// ─── Appointment / Janji Temu (admin + resepsionis) ───────────────────────────
Route::middleware(['auth', 'role:admin,resepsionis'])->group(function () {
    Route::resource('appointment', \App\Http\Controllers\AppointmentController::class);
    Route::patch('appointment/{appointment}/status', [\App\Http\Controllers\AppointmentController::class, 'updateStatus'])->name('appointment.update-status');
    // API endpoint dropdown dokter per departemen
    Route::get('api/department/{department}/doctors', [\App\Http\Controllers\AppointmentController::class, 'getDoctorsByDepartment'])->name('api.department.doctors');
});

// ─── Rekam Medis (admin + dokter) ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,dokter'])->group(function () {
    Route::resource('rekam-medis', \App\Http\Controllers\RekamMedisController::class);
});

// ─── Obat (admin + apoteker) ──────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,apoteker'])->group(function () {
    Route::resource('obat', \App\Http\Controllers\ObatController::class);
    Route::patch('obat/{obat}/stock', [\App\Http\Controllers\ObatController::class, 'updateStock'])->name('obat.update-stock');
});

// ─── Resep (admin + dokter + apoteker) ────────────────────────────────────────
Route::middleware(['auth', 'role:admin,dokter,apoteker'])->group(function () {
    Route::get('resep/create',     [\App\Http\Controllers\ResepController::class, 'create'])->name('resep.create');
    Route::post('resep',           [\App\Http\Controllers\ResepController::class, 'store'])->name('resep.store');
    Route::get('resep/{resep}',    [\App\Http\Controllers\ResepController::class, 'show'])->name('resep.show');
    Route::delete('resep/{resep}', [\App\Http\Controllers\ResepController::class, 'destroy'])->name('resep.destroy');
});

// ─── Tagihan & Pembayaran (admin + kasir) ─────────────────────────────────────
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::resource('tagihan', \App\Http\Controllers\TagihanController::class)->except(['edit','update']);
    Route::post('tagihan/{tagihan}/payment', [\App\Http\Controllers\TagihanController::class, 'storePayment'])->name('tagihan.payment');
});
