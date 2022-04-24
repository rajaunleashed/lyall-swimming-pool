<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $start_date = $end_date = null;
        $data = [];
        if (request()->has('start_date')) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
        }
        if (request()->has('end_date')) {
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
        }

        $data['sales'] = Ticket::startDate($start_date)
            ->endDate($end_date)->sum('amount');

        $data['no_of_persons'] = Ticket::whereType('Person')
            ->startDate($start_date)
            ->endDate($end_date)->count();

        $data['no_of_lockers'] = Ticket::whereType('Locker')
            ->startDate($start_date)
            ->endDate($end_date)
            ->count();

        $data['no_of_bookings'] = Ticket::whereType('Booking')
            ->startDate($start_date)
            ->endDate($end_date)
            ->count();

        $data['expenses'] = Expense::startDate($start_date)
            ->endDate($end_date)
            ->sum('amount');

        return view('voyager::dashboard', $data);
    }

}
