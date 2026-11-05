<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
Route::get('/login', [AuthController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware(['guest','throttle:5,1']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
