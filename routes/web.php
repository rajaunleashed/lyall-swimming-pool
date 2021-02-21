<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SaleController;
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
    return redirect()->to('/admin');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/load-relations', [\App\Http\Controllers\DataController::class, 'loadSalesRelations']);
    Route::prefix('sales')->group(function() {
        Route::post('create', [SaleController::class, 'add']);
        Route::get('{id}/get', [SaleController::class, 'getSaleByID']);
        Route::post('edit/{id}', [SaleController::class, 'updateByID']);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



