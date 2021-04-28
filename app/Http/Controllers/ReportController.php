<?php

namespace App\Http\Controllers;

use App\Models\MonthlyStock;
use App\Repositories\StockRepository;
use App\Utilities\Helper;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class ReportController extends Controller
{
    protected $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function stockSale($month = null) {

        if (is_null($month)) {
            $month = now()->startOfMonth()->toDateString();
            return redirect()->to("admin/reports/stock-sale/$month");
        }

        $data = $this->getStockSaleReport($month);
        return view('voyager::reports.stock-sale', $data);
    }

    public function printStockSale($month = null)
    {
        $data = $this->getStockSaleReport($month);
        return view('voyager::reports.stock-sale-print', $data);
    }

    private function getStockSaleReport($month)
    {

        $monthYear = Helper::getMonthYearFromDate($month);

        $stock = $this->stockRepository->getMonthlyStockReport($monthYear);

        $months = MonthlyStock::select('date')->distinct()->pluck('date');
        $stock = $stock->groupBy('group');

        return [
            'stock'  => $stock,
            'months' => $months,
            'month'  => $month
        ];
    }
}
