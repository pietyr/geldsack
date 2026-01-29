<?php

use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('wallets', WalletController::class)->middleware(['auth', 'verified']);
Route::resource('categories', TransactionCategoryController::class)->middleware(['auth', 'verified']);
Route::resource('transactions', TransactionController::class)->middleware(['auth', 'verified']);

require __DIR__ . '/settings.php';
