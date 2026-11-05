<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/plantilla', [TicketController::class, 'design'])->name('template.design');
    Route::get('/tickets', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->middleware('throttle:10,1')->name('tickets.store');
    Route::delete('/tickets/{batch}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/historial', [TicketController::class, 'history'])->name('tickets.history');
    Route::get('/descargas/{download}/{format}', [DownloadController::class, 'download'])->name('downloads.file');
    Route::get('/descargas', [DownloadController::class, 'index'])->name('downloads.index');
    Route::get('/usuarios', [UserController::class, 'index'])->middleware('can:manage-users')->name('users.index');
    Route::post('/usuarios', [UserController::class, 'store'])->middleware('can:manage-users')->name('users.store');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->middleware('can:manage-users')->name('users.update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->middleware('can:manage-users')->name('users.destroy');
    Route::get('/configuracion', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/configuracion', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/configuracion/ajax', [SettingsController::class, 'saveAjax'])->name('settings.save.ajax');
    Route::post('/configuracion/assets', [SettingsController::class, 'saveAssets'])->name('settings.save.assets');
});

require __DIR__.'/auth.php';
