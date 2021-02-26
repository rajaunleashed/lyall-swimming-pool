<?php

namespace App\Observers;

use App\Models\MonthlyStock;
use App\Models\Product;
use App\Models\Supplier;

class MonthlyStockObserver
{
    /**
     * Handle the Purchase "creating" event.
     *
     * @param  \App\Models\MonthlyStock  $monthlyStock
     * @return void
     */
    public function saving(MonthlyStock $monthlyStock)
    {
        if ($monthlyStock->product_id) {
            $product = Product::find($monthlyStock->product_id);
            $monthlyStock->product_name = $product->name;
        }

        if ($monthlyStock->supplier_id) {
            $supplier = Supplier::find($monthlyStock->supplier_id);
            $monthlyStock->supplier_name = $supplier->name;
        }

        $monthlyStock->quantity = $monthlyStock->opening_stock + $monthlyStock->stock_in;

    }


    /**
     * Handle the Purchase "created" event.
     *
     * @param  \App\Models\MonthlyStock $monthlyStock
     * @return void
     */
    public function created(MonthlyStock $monthlyStock)
    {
        //
    }


    /**
     * Handle the Purchase "updated" event.
     *
     * @param  \App\Models\MonthlyStock $monthlyStock
     * @return void
     */
    public function updated(MonthlyStock $monthlyStock)
    {
    }

    /**
     * Handle the Purchase "deleted" event.
     *
     * @param  \App\Models\MonthlyStock $monthlyStock
     * @return void
     */
    public function deleted(MonthlyStock $monthlyStock)
    {
        //
    }

    /**
     * Handle the Purchase "restored" event.
     *
     * @param  \App\Models\MonthlyStock $monthlyStock
     * @return void
     */
    public function restored(MonthlyStock $monthlyStock)
    {
        //
    }

    /**
     * Handle the Purchase "force deleted" event.
     *
     * @param  \App\Models\MonthlyStock $monthlyStock
     * @return void
     */
    public function forceDeleted(MonthlyStock $monthlyStock)
    {
        //
    }
}
