<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('iniciar-sesión', LoginController::class)->name('login');

Route::post('acceder', [LoginController::class, 'acceder'])->name('acceder');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');