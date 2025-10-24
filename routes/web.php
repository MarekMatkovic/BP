<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // súčasť Breeze
    })->name('dashboard');
});
require __DIR__.'/auth.php';

