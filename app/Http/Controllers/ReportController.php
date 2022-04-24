<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\MonthlyStock;
use App\Models\Ticket;
use App\Repositories\StockRepository;
use App\Utilities\Helper;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class ReportController extends Controller
{

    public function expenses() {

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $years = array_combine(range(date("Y"), 1910), range(date("Y"), 1910));

        $expenses = Expense::all();
        $total = $expenses->sum('amount');
        if (\request()->has('month') && \request()->has('year')) {
            $expenses = Expense::whereExpenseMonth(\request()->get('month'))->whereExpenseYear(\request()->get('year'))->get();
            $total = $expenses->sum('amount');
        }

        return view('voyager::reports.expenses', compact('months', 'years', 'expenses', 'total'));
    }

    public function printExpenses() {

        $expenses = Expense::all();
        $total = $expenses->sum('amount');
        if (\request()->has('month') && \request()->has('year')) {
            $expenses = Expense::whereExpenseMonth(\request()->get('month'))->whereExpenseYear(\request()->get('year'))->get();
            $total = $expenses->sum('amount');
        }

        return view('voyager::reports.expenses-print', compact('expenses', 'total'));

    }

}
