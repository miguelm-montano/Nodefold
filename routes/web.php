<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('folders', FolderController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('resources', ResourceController::class)
        ->only(['store', 'update', 'destroy']);

});

Route::view('profile', 'profile')
    ->middleware('auth')
    ->name('profile');

require __DIR__.'/auth.php';