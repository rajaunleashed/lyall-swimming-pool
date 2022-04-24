<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SaleController;
use \App\Http\Controllers\InvoiceController;
use \App\Http\Controllers\DataController;
use \App\Http\Controllers\StockController;
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
    Route::get('/tickets/print/{id}', [\App\Http\Controllers\TicketController::class, 'printTicket'])
        ->name('print.ticket');

});

Auth::routes();
