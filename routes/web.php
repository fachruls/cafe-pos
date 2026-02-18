<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LoginPage;
use App\Livewire\ShiftManager;
use App\Livewire\PosPage;
use App\Http\Middleware\EnsureShiftIsOpen;

// 1. Halaman Login (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

// 2. Halaman Setelah Login (Auth required)
Route::middleware('auth')->group(function () {

    // Logout (Sederhana)
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');

    // --- FITUR SHIFT (Buka/Tutup Toko) ---
    // Route ini BEBAS dari middleware EnsureShiftIsOpen
    // Karena kasir harus bisa akses ini untuk mulai kerja
    Route::get('/shift/open', ShiftManager::class)->name('shift.open');

    // --- AREA OPERASIONAL (Wajib sudah Buka Shift) ---
    Route::middleware([EnsureShiftIsOpen::class])->group(function () {
        
        // Halaman Utama Kasir
        Route::get('/pos', PosPage::class)->name('pos.index');
        
        // Bisa tambah route lain disini (e.g., Laporan, Dapur)
    });

});