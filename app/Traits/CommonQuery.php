<?php


namespace App\Traits;


use Illuminate\Support\Facades\DB;

trait CommonQuery
{
    public function scopeStartDate($query, $start_date) {
        if (!is_null($start_date)) {
            $query->where(DB::raw('DATE(created_at)'),'>=', $start_date);
        }
    }

    public function scopeEndDate($query, $end_date) {
        if (!is_null($end_date)) {
            $query->where(DB::raw('DATE(created_at)'),'<=', $end_date);
        }
    }
}
