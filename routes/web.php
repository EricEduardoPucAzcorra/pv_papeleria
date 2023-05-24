<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\RouteController;
use App\Http\Livewire\Reportes\Reporte;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function() {

    Route::get('/', RouteController::class)->name('dashboard');

    Route::get('productos', [RouteController::class, 'productos'])->name('productos');

    Route::get('categorias', [RouteController::class, 'categorias'])->name('categorias');

    Route::get('punto-venta', [RouteController::class, 'ventas'])->name('ventas');

    Route::get('cancelar-venta', [RouteController::class, 'cancelacion'])->name('cancelacion');

    Route::get('calcular-precios', [RouteController::class, 'precios'])->name('precios');

    Route::get('deudas', [RouteController::class, 'deudas'])->name('deudas.index');

    Route::get('deudas/{deudor}', [RouteController::class, 'deudasShow'])->name('deudas.show');

    Route::get('reportes', Reporte::class)->name('reportes');

    Route::get('reportes/pdf/{inicio}/{fin}', PDFController::class)->name('reportes.pdf');

});