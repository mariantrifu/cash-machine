<?php

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

Route::get('/', function () {
    return view('index');
});
Route::get('/add-money', [\App\Http\Controllers\CashMachineController::class, 'selectTransactionType']);
Route::post('/add-cash', [\App\Http\Controllers\CashMachineController::class, 'addCash']);
Route::post('/add-card', [\App\Http\Controllers\CashMachineController::class, 'addCard']);
Route::post('/add-transfer', [\App\Http\Controllers\CashMachineController::class, 'addTransfer']);
