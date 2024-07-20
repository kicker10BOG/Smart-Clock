<?php

use App\Http\Controllers\ClockController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'home'])->name('home');
Route::put('/flash', [MainController::class, 'addFlash'])->name('addFlash');
Route::delete('/flash', [MainController::class, 'removeFlash'])->name('removeFlash');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
});

Route::controller(ClockController::class)->prefix('clock')->name('clocks.')->group(function () {
    Route::get('/{clock}', 'show')->whereNumber('clock')->name('show');
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/new', 'create')->name('create');
        Route::post('/new', 'store')->name('store');
        Route::put('/{clock}', 'update')->whereNumber('clock')->name('update');
        Route::delete('/{clock}', 'destroy')->whereNumber('clock')->name('destroy');
    });
});
