<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ReportController;

Route::get('stock-sale/{month?}', [ReportController::class, 'stockSale']);
Route::get('print-stock-sale/{month?}', [ReportController::class, 'printStockSale'])->name('report.stock.sale');
