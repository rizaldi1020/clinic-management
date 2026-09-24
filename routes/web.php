<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ─── Auth ─────────────────────────────────────────────────────────────────────
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ─── Dashboard per role ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard',       [DashboardController::class, 'admin'])
        ->middleware('role:admin')->name('admin.dashboard');
    Route::get('/dokter/dashboard',      [DashboardController::class, 'dokter'])
        ->middleware('role:dokter')->name('dokter.dashboard');
    Route::get('/resepsionis/dashboard', [DashboardController::class, 'resepsionis'])
        ->middleware('role:resepsionis')->name('resepsionis.dashboard');
    Route::get('/apoteker/dashboard',    [DashboardController::class, 'apoteker'])
        ->middleware('role:apoteker')->name('apoteker.dashboard');
    Route::get('/kasir/dashboard',       [DashboardController::class, 'kasir'])
        ->middleware('role:kasir')->name('kasir.dashboard');
    Route::get('/pasien/dashboard',      [DashboardController::class, 'pasien'])
        ->middleware('role:pasien')->name('pasien.dashboard');
});

// ─── Pasien ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,resepsionis'])->group(function () {
    Route::resource('pasien', \App\Http\Controllers\PasienController::class);
});
Route::middleware(['auth', 'role:dokter,apoteker,kasir'])->group(function () {
    Route::get('pasien',          [\App\Http\Controllers\PasienController::class, 'index'])->name('pasien.index.readonly');
    Route::get('pasien/{pasien}', [\App\Http\Controllers\PasienController::class, 'show'])->name('pasien.show.readonly');
});

// ─── Dokter ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('dokter', \App\Http\Controllers\DokterController::class);
    Route::post  ('dokter/{dokter}/jadwal',            [\App\Http\Controllers\JadwalDokterController::class, 'store'])->name('jadwal.store');
    Route::put   ('dokter/{dokter}/jadwal/{jadwal}',   [\App\Http\Controllers\JadwalDokterController::class, 'update'])->name('jadwal.update');
    Route::delete('dokter/{dokter}/jadwal/{jadwal}',   [\App\Http\Controllers\JadwalDokterController::class, 'destroy'])->name('jadwal.destroy');
});
Route::middleware(['auth', 'role:dokter,resepsionis,apoteker,kasir'])->group(function () {
    Route::get('dokter',          [\App\Http\Controllers\DokterController::class, 'index'])->name('dokter.index.readonly');
    Route::get('dokter/{dokter}', [\App\Http\Controllers\DokterController::class, 'show'])->name('dokter.show.readonly');
});

// ─── Departemen ───────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('departemen', \App\Http\Controllers\DepartemenController::class);
});
Route::middleware(['auth', 'role:dokter,resepsionis,apoteker,kasir'])->group(function () {
    Route::get('departemen',                [\App\Http\Controllers\DepartemenController::class, 'index'])->name('departemen.index.readonly');
    Route::get('departemen/{departemen}',   [\App\Http\Controllers\DepartemenController::class, 'show'])->name('departemen.show.readonly');
});

// ─── Manajemen User ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::patch('user/{user}/toggle-status',  [\App\Http\Controllers\UserController::class, 'toggleStatus'])->name('user.toggle-status');
    Route::patch('user/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])->name('user.reset-password');
});

// ─── Appointment ──────────────────────────────────────────────────────────────
// Semua role bisa index & show
Route::middleware(['auth', 'role:admin,resepsionis,dokter,kasir,apoteker'])->group(function () {
    Route::get('appointment',               [\App\Http\Controllers\AppointmentController::class, 'index'])->name('appointment.index');
    Route::get('appointment/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'show'])->name('appointment.show');
});
// Hanya admin & resepsionis yang bisa create/store/edit/update/destroy
Route::middleware(['auth', 'role:admin,resepsionis'])->group(function () {
    Route::get   ('appointment/create',              [\App\Http\Controllers\AppointmentController::class, 'create'])->name('appointment.create');
    Route::post  ('appointment',                     [\App\Http\Controllers\AppointmentController::class, 'store'])->name('appointment.store');
    Route::get   ('appointment/{appointment}/edit',  [\App\Http\Controllers\AppointmentController::class, 'edit'])->name('appointment.edit');
    Route::put   ('appointment/{appointment}',       [\App\Http\Controllers\AppointmentController::class, 'update'])->name('appointment.update');
    Route::delete('appointment/{appointment}',       [\App\Http\Controllers\AppointmentController::class, 'destroy'])->name('appointment.destroy');
    Route::patch ('appointment/{appointment}/status',[\App\Http\Controllers\AppointmentController::class, 'updateStatus'])->name('appointment.update-status');
});
Route::middleware('auth')->get(
    'api/department/{department}/doctors',
    [\App\Http\Controllers\AppointmentController::class, 'getDoctorsByDepartment']
)->name('api.department.doctors');

// ─── Rekam Medis ──────────────────────────────────────────────────────────────
// Semua role bisa index & show (route name: rekam-medis.index, rekam-medis.show)
Route::middleware(['auth', 'role:admin,dokter,resepsionis,apoteker,kasir'])->group(function () {
    Route::get('rekam-medis', [\App\Http\Controllers\RekamMedisController::class, 'index'])
        ->name('rekam-medis.index');
    Route::get('rekam-medis/{rekamMedis}', [\App\Http\Controllers\RekamMedisController::class, 'show'])
        ->name('rekam-medis.show');
});
// Hanya admin & dokter yang bisa create/store/edit/update/destroy
Route::middleware(['auth', 'role:admin,dokter'])->group(function () {
    Route::get   ('rekam-medis/create',             [\App\Http\Controllers\RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post  ('rekam-medis',                    [\App\Http\Controllers\RekamMedisController::class, 'store'])->name('rekam-medis.store');
    Route::get   ('rekam-medis/{rekamMedis}/edit',  [\App\Http\Controllers\RekamMedisController::class, 'edit'])->name('rekam-medis.edit');
    Route::put   ('rekam-medis/{rekamMedis}',       [\App\Http\Controllers\RekamMedisController::class, 'update'])->name('rekam-medis.update');
    Route::delete('rekam-medis/{rekamMedis}',       [\App\Http\Controllers\RekamMedisController::class, 'destroy'])->name('rekam-medis.destroy');
});

// ─── Obat ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,apoteker'])->group(function () {
    Route::resource('obat', \App\Http\Controllers\ObatController::class);
    Route::patch('obat/{obat}/stock', [\App\Http\Controllers\ObatController::class, 'updateStock'])->name('obat.update-stock');
});
Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('obat',        [\App\Http\Controllers\ObatController::class, 'index'])->name('obat.index.readonly');
    Route::get('obat/{obat}', [\App\Http\Controllers\ObatController::class, 'show'])->name('obat.show.readonly');
});

// ─── Resep ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,dokter'])->group(function () {
    Route::get ('resep/create', [\App\Http\Controllers\ResepController::class, 'create'])->name('resep.create');
    Route::post('resep',        [\App\Http\Controllers\ResepController::class, 'store'])->name('resep.store');
});
Route::middleware(['auth', 'role:admin,dokter,apoteker'])->group(function () {
    Route::get   ('resep/{resep}', [\App\Http\Controllers\ResepController::class, 'show'])->name('resep.show');
    Route::delete('resep/{resep}', [\App\Http\Controllers\ResepController::class, 'destroy'])->name('resep.destroy');
});

// ─── Tagihan & Pembayaran ─────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::resource('tagihan', \App\Http\Controllers\TagihanController::class)->except(['edit','update']);
    Route::post('tagihan/{tagihan}/payment', [\App\Http\Controllers\TagihanController::class, 'storePayment'])->name('tagihan.payment');
});
Route::middleware(['auth', 'role:dokter,resepsionis,apoteker'])->group(function () {
    Route::get('tagihan',           [\App\Http\Controllers\TagihanController::class, 'index'])->name('tagihan.index.readonly');
    Route::get('tagihan/{tagihan}', [\App\Http\Controllers\TagihanController::class, 'show'])->name('tagihan.show.readonly');
});

// ─── Profile ──────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('profile',          [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile',          [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ─── Cetak / Print ────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('print/tagihan/{tagihan}', function (\App\Models\Bill $tagihan) {
        $tagihan->load(['patient','appointment.doctor.user','appointment.department','details','payments']);
        return view('print.invoice', compact('tagihan'));
    })->name('print.tagihan');

    Route::get('print/rekam-medis/{rekamMedis}', function (\App\Models\MedicalRecord $rekamMedis) {
        $rekamMedis->load(['patient','doctor.user','appointment.department','prescriptions.details.medicine']);
        return view('print.rekam-medis', compact('rekamMedis'));
    })->name('print.rekam-medis');
});