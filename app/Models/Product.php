<?php

namespace App\Models;

use App\Utilities\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $with = ['stock'];

    function stock() {
        $monthYear = Helper::getMonthYearFromDate();
        return $this->hasMany(MonthlyStock::class)
            ->selectRaw('monthly_stocks.product_id, SUM(quantity) as totalStock')
            ->whereYear('date', $monthYear['year'])
            ->whereMonth('date', $monthYear['month'])
            ->whereIsMonthClosed(0)
            ->groupBy('monthly_stocks.product_id');
    }

    /*
     * @param $items
     * @param $callable
     * @return $callable
     *
     * */

    static function validateStock($items, callable $callable)
    {
        foreach ($items as $item) {

            $totalAvailStock = MonthlyStock::getAvailableStockProducts($item['product_id']);
            $totalAvailStock = $totalAvailStock->sum('quantity');

            // Check if it is updating the existing data
            if(isset($item['id'])) {
                // Get Previous saved sale Product
                $existingQuantity = SaleProduct::whereId($item['id'])->value('quantity');
                // If new quantity is greater than previous sale quantity
                $totalAvailStock = $totalAvailStock + $existingQuantity;
            }

            if ($totalAvailStock < $item['quantity']) {
                $callable(false);
            }
        }

        $callable(true);

    }

}
