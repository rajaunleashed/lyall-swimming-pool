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

    Route::get('/load-relations', [DataController::class, 'loadSalesRelations']);
    Route::prefix('sales')->group(function() {
        Route::post('create', [SaleController::class, 'add']);
        Route::get('{saleId}/get/payment', [SaleController::class, 'getPaymentDetail']);
        Route::get('{id}/get', [SaleController::class, 'getSaleByID']);
        Route::post('edit/{id}', [SaleController::class, 'updateByID']);
        Route::get('{id}/invoice', [InvoiceController::class, 'show'])->name('sale.invoice');
        Route::post('invoice/update', [InvoiceController::class, 'updateInvoice'])->name('sales.invoice');
        Route::get('invoice/{id}/download', [InvoiceController::class, 'downloadInvoice'])->name('sales.invoice.download');
        Route::get('invoice/{id}/print', [InvoiceController::class, 'printInvoice'])->name('sales.invoice.print');
        Route::get('invoice/{id}/print', [InvoiceController::class, 'printInvoice'])->name('sales.invoice.print');
    });

    Route::prefix('stock')->group(function() {
        Route::post('close-month/{month}', [StockController::class, 'closeMonth']);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('points', function() {
    $data = \DB::table('point_data')->whereLanguage('en')->get();
    foreach($data as $point_data) {
        $transliterator = Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', Transliterator::FORWARD);
        \DB::table('point_data')->where('id', $point_data->id)->update([
          'clinical_application' => strip_tags($transliterator->transliterate($point_data->clinical_application)),
          'combinations' => strip_tags($transliterator->transliterate($point_data->combinations)),
          'text' => strip_tags($transliterator->transliterate($point_data->text)),
          'location' => strip_tags($transliterator->transliterate($point_data->location)),
          'needling' => strip_tags($transliterator->transliterate($point_data->needling)),
          'actions' => strip_tags($transliterator->transliterate($point_data->actions)),
          'indications' => strip_tags($transliterator->transliterate($point_data->indications)),
          'commentary' => strip_tags($transliterator->transliterate($point_data->commentary)),
          'location_note' => strip_tags($transliterator->transliterate($point_data->location_note)),
          'classification' => strip_tags($transliterator->transliterate($point_data->classification))
        ]);
    }

    $combinations = \DB::table('point_data')->whereId('3')->get();
    return $combinations;
});
