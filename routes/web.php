<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LoginPage;
use App\Livewire\ShiftManager;
use App\Livewire\PosPage;
use App\Livewire\ProductManager;
use App\Http\Middleware\EnsureShiftIsOpen;

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::middleware('auth')->group(function () {

    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');

    Route::get('/shift/open', ShiftManager::class)->name('shift.open');

    // Rute Gudang Menu (Aman diakses admin tanpa buka shift)
    Route::get('/products', ProductManager::class)->name('products.index');

    Route::middleware([EnsureShiftIsOpen::class])->group(function () {
        Route::get('/pos', PosPage::class)->name('pos.index');
    });

});