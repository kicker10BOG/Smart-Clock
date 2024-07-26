<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AlarmController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClockController;

Route::get('/', [MainController::class, 'home'])->name('home');
Route::put('/flash', [MainController::class, 'addFlash'])->name('addFlash');
Route::delete('/flash', [MainController::class, 'removeFlash'])->name('removeFlash');

Route::middleware(['auth',])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
});

Route::controller(ClockController::class)->prefix('clock')->name('clocks.')->group(function () {
    Route::get('/{clock}', 'show')->whereNumber('clock')->name('show');
    Route::middleware(['auth'])->group(function () {
        Route::get('/new', 'create')->name('create');
        Route::post('/new', 'store')->name('store');
        Route::put('/{clock}', 'update')->whereNumber('clock')->name('update');
        Route::delete('/{clock}', 'destroy')->whereNumber('clock')->name('destroy');
    });
});

Route::controller(AlarmController::class)->prefix('alarm')->name('alarms.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::post('/new', 'store')->name('store');
        Route::put('/{alarm}', 'update')->whereNumber('alarm')->name('update');
        Route::delete('/{alarm}', 'destroy')->whereNumber('alarm')->name('destroy');
        Route::put('/{alarm}/enable', 'enable')->whereNumber('alarm')->name('enable');
        Route::put('/{alarm}/disable', 'disable')->whereNumber('alarm')->name('disable');
        Route::put('/{alarm}/{day}/enable', 'enableDay')->whereNumber('alarm')->name('enableDay');
        Route::put('/{alarm}/{day}/disable', 'disableDay')->whereNumber('alarm')->name('disableDay');
    });
});

require __DIR__.'/auth.php';
