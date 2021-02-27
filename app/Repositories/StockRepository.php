<?php


namespace App\Repositories;


use App\Models\MonthlyStock;
use Illuminate\Support\Facades\DB;

class StockRepository
{
    /* Get Sale Report
     * @param $monthYear
     * @return Collection
     * */
    public function getMonthlyStockReport($monthYear)
    {
        $stock = MonthlyStock::join('products as p', 'p.id', '=', 'monthly_stocks.product_id')
                        ->join('sale_products as sp', 'sp.product_id', '=', 'monthly_stocks.product_id')
                        ->join('groups as g', 'g.id','=', 'p.group_id')
//                        ->join('brands as b', 'b.id', '=', 'p.brand_d')
                        ->where(function($builder) use ($monthYear) {
                            $builder->whereMonth('sp.created_at', $monthYear['month'])
                                ->whereYear('sp.created_at', $monthYear['year']);
                        })
                        ->where(function($builder) use ($monthYear) {
                            $builder->whereMonth('monthly_stocks.date', $monthYear['month'])
                                ->whereYear('monthly_stocks.date', $monthYear['year']);
                        })
                        ->select(
                            'g.name as group',
//                            'b.name as brand',
                            'p.trade_price',
                            'p.name',
                            'opening_stock',
                            'stock_in',
                            'monthly_stocks.quantity as stock_quantity',
                            'stock_out',
                            'bonus',
                            'expired',
                            'date',
                            'monthly_stocks.id as stock_id',
                            'sp.product_id as item_id',
                            DB::raw('SUM(sp.quantity) as sale_quantity'),
                            DB::raw('SUM(sp.total_price) as sale_amount')
                        )
                        ->groupBy('sp.product_id')
                        ->orderBy('g.name')
                        ->get();

        return $stock;
    }
}
