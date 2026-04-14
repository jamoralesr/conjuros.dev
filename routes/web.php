<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

// Placeholder — implementado en Fase F (CheckoutController).
Route::get('checkout/{plan}/{interval}', fn () => abort(503, 'Checkout no configurado'))
    ->middleware('auth')
    ->name('checkout.start');

require __DIR__.'/front.php';
require __DIR__.'/back.php';
require __DIR__.'/settings.php';
