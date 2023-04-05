<?php

use App\Http\Controllers\Api\PenjualanController;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(PenjualanController::class)->prefix('penjualan')->name('penjualan.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/{id}/detail', 'detail')->name('detail');
    Route::post('/{id}/update', 'update')->name('update');
    Route::post('/{id}/publish', 'publish')->name('publish');
});
