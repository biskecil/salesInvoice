<?php

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

Route::prefix('sales')->group(function () {
    Route::post('/create', [SalesInvController::class, 'create']);
    Route::get('/show', [SalesInvController::class, 'show']);
    Route::get('/edit/{id}', [SalesInvController::class, 'edit']);
});
