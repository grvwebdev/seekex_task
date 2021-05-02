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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/racks', [App\Http\Controllers\RacksController::class, 'index'])->name('racks');
Route::post('/update_racks', [App\Http\Controllers\RacksController::class, 'update'])->name('updateRacks');
Route::get('/inbound', [App\Http\Controllers\InboundController::class, 'index'])->name('inbound');
Route::post('/update_inbound', [App\Http\Controllers\InboundController::class, 'skuInboundDone'])->name('updateInbound');