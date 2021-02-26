<?php


namespace App\Services;


use App\Models\MonthlyStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StockService
{
    public static function checkMonthlyClosed($month) {
        if(!$month) {
            return false;
        }

        return MonthlyStock::where('date', $month)->whereIsMonthClosed(0)->exists();
    }

    public static function closeMonth($month) {
        try {
            $m = Carbon::parse($month)->month;
            $y = Carbon::parse($month)->year;

            $stockQuery = MonthlyStock::whereYear('date', $y)->whereMonth('date', $m)->whereIsMonthClosed(0);
            $monthlyStocks = $stockQuery->get();
            if(count($monthlyStocks)) {
                DB::beginTransaction();
                $stockQuery->update([
                    'is_month_closed' => 1
                ]);

                foreach ($monthlyStocks as $stock) {
                    if ($stock->quantity > 0) {
                        $newStock = new MonthlyStock();
                        $newStock->product_id = $stock->product_id;
                        $newStock->supplier_id = $stock->supplier_id;
                        $newStock->opening_stock = $stock->quantity;
                        $newStock->stock_in = 0;
                        $newStock->date = Carbon::parse($month)->addMonth()->startOfMonth()->toDateString();
                        $newStock->save();
                    }
                }

                DB::commit();

            } else {
                return redirect()->back()->with([
                    'alert-type' => 'warning',
                    'message' => "Month $month already is closed."
                ]);
            }


            return redirect()->back()->with([
                'alert-type' => 'success',
                'message' => "Month $month is closed"
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with([
                'alert-type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }



    }

}
