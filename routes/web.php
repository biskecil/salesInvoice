<?php

use App\Http\Controllers\MasterController;
use App\Http\Controllers\SalesInvController;
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



Route::get('/', [SalesInvController::class, 'form'])->name('sales.form');

Route::prefix('pack')->group(function () {
    Route::get('/show', [SalesInvController::class, 'show_pack']);
    Route::get('/getData/Nota/', [SalesInvController::class, 'getDataNotaPack']);
    Route::get('/cetakNota/', [SalesInvController::class, 'cetakDataNotaPack']);
    Route::get('/prevNota/', [SalesInvController::class, 'prevDataNotaPack']);
});
Route::prefix('pricelist')->group(function () {
    Route::get('/show', [MasterController::class, 'show_pricelist']);
    Route::get('/show_data', [MasterController::class, 'show_pricelist_data']);
    Route::get('/getDataAll', [MasterController::class, 'show_pricelist_grosir_data']);
    Route::get('/create', [MasterController::class, 'create_pricelist']);
    Route::post('/store', [MasterController::class, 'store_pricelist']);
    Route::get('/edit/{cus}/{cat}/{car}', [MasterController::class, 'edit_pricelist']);
    Route::post('/update', [MasterController::class, 'update_pricelist']);
});
Route::prefix('grosir')->group(function () {
    Route::get('/show', [MasterController::class, 'show_grosir']);
    Route::get('/create', [MasterController::class, 'create_grosir']);
    Route::get('/edit/{id}', [MasterController::class, 'edit_grosir']);
    Route::post('/store', [MasterController::class, 'store_grosir']);
    Route::post('/update', [MasterController::class, 'update_grosir']);
    Route::get('/show_data', [MasterController::class, 'show_grosir_data']);
});

Route::prefix('sales')->group(function () {
    Route::get('/getData/Nota/search', [SalesInvController::class, 'getDataNotaSearch']);
    Route::get('/getData/subGros/', [SalesInvController::class, 'getDataSubGros']);
    Route::get('/getData/Nota/', [SalesInvController::class, 'getDataNota']);
    Route::get('/getData/NotaAll/', [SalesInvController::class, 'getDataNotaAll']);
    Route::get('/getData/Gros/{ID}', [SalesInvController::class, 'getDataGros']);
    Route::get('/getData/Price/', [SalesInvController::class, 'getDataPrice']);
    Route::get('/create', [SalesInvController::class, 'create']);
    Route::post('/store', [SalesInvController::class, 'store']);
    Route::get('/show', [SalesInvController::class, 'show']);
    Route::get('/edit/{Nota}', [SalesInvController::class, 'edit']);
    Route::get('/detail/{Nota}', [SalesInvController::class, 'detail']);
    Route::put('/update/{ID}', [SalesInvController::class, 'update']);
    Route::get('/cetakNota/{style}/{ID}', [SalesInvController::class, 'cetakNota']);
    Route::get('/cetakBarcode/{Nota}', [SalesInvController::class, 'cetakBarcode']);
});

// Auth::routes();
Auth::routes(['register' => false]);

