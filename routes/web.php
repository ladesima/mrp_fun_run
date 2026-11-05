<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [UserController::class, 'landingPage'])->name('home');

Route::get('/register', function () {
    return redirect()->route('home');
});

Route::get('/register/{kategori}', [UserController::class, 'showRegisterForm'])->name('register.form');

// Tambahkan rute POST ini untuk memproses simpan data
Route::post('/register/process', [UserController::class, 'processRegister'])->name('register.submit');

// Rute untuk Halaman Daftar Peserta Publik
Route::get('/peserta', [App\Http\Controllers\UserController::class, 'participantList'])->name('participants.list');

// Rute untuk menampilkan halaman pembayaran
Route::get('/payment/{code}', [UserController::class, 'paymentPage'])->name('payment.page');

// Rute untuk memproses upload bukti bayar manual
Route::post('/payment/upload/{code}', [UserController::class, 'uploadProof'])->name('payment.upload');

// Rute untuk menampilkan E-Ticket peserta
Route::get('/ticket/{code}', [UserController::class, 'showTicket'])->name('ticket.show');

// Rute untuk fitur Cek Status / Cari Tiket
Route::get('/cek-status', [App\Http\Controllers\UserController::class, 'checkStatusPage'])->name('check.status');
Route::post('/cek-status', [App\Http\Controllers\UserController::class, 'findTicket'])->name('find.ticket');

// Rute Login (Bisa diakses siapa saja)
Route::get('/admin-login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin-login', [AuthController::class, 'login'])->name('admin.login.process');
Route::post('/admin-logout', [AuthController::class, 'logout'])->name('admin.logout');

// Rute Admin Panel (HANYA BISA DIAKSES JIKA SUDAH LOGIN)
Route::middleware(['auth'])->prefix('admin-panel')->group(function () {
    
    // ==========================================
    // 1. RUTE UMUM ADMIN (Bisa diakses Superadmin & Admin Racepack)
    // ==========================================
    Route::get('/racepack', [AdminController::class, 'racepackIndex'])->name('admin.racepack');
    Route::post('/racepack/{id}', [AdminController::class, 'toggleRacepack'])->name('admin.racepack.toggle');
    Route::post('/racepack-scan', [AdminController::class, 'scanRacepack'])->name('admin.racepack.scan');
    Route::post('/racepack/manual/{id}', [AdminController::class, 'manualRacepack'])->name('admin.racepack.manual');
    Route::get('/racepack/backdrop/{id}', [AdminController::class, 'racepackBackdrop'])->name('admin.racepack.backdrop');
    Route::get('/export-racepack', [AdminController::class, 'exportRacepack'])->name('admin.export.racepack');
    Route::get('/receipt-file/{id}', [AdminController::class, 'viewReceipt'])->name('admin.receipt');
    Route::get('/doorprize', [AdminController::class, 'doorprizeIndex'])->name('admin.doorprize');
    Route::get('/doorprize/stage', [AdminController::class, 'doorprizeStage'])->name('admin.doorprize.stage');
    Route::get('/doorprize/data', [AdminController::class, 'doorprizeData'])->name('admin.doorprize.data');

    // ==========================================
    // 2. RUTE KHUSUS SUPERADMIN (Hanya Superadmin yang bisa akses)
    // ==========================================
    Route::middleware(['superadmin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/verify/{id}', [AdminController::class, 'verifyPayment'])->name('admin.verify');
        Route::post('/cancel-verify/{id}', [AdminController::class, 'cancelVerify'])->name('admin.cancel_verify');
        Route::delete('/peserta/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::get('/peserta/{id}', [AdminController::class, 'show'])->name('admin.show');
        Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('admin.export');
        Route::get('/duplicates', [AdminController::class, 'duplicatesIndex'])->name('admin.duplicates');

        // Manajemen Akun Admin
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('admin.users');
        Route::post('/users', [AdminController::class, 'userStore'])->name('admin.users.store');
        Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');
    });

});