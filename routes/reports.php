<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ReportController;

Route::get('expenses', [ReportController::class, 'expenses']);
Route::get('expenses/print', [ReportController::class, 'printExpenses'])->name('reports.expenses');
