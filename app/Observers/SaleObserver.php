<?php

namespace App\Observers;

use App\Models\MonthlyStock;
use App\Models\Sale;
use App\Models\SaleProduct;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function created(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "updated" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function updated(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "deleted" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function deleting(Sale $sale)
    {
        $saleProducts = SaleProduct::whereSaleId($sale->id)->get();
        foreach($saleProducts as $saleProduct) {
            $purchaseProduct = MonthlyStock::whereProductId($saleProduct->product_id)->latest()->first();
            $stock_out = $purchaseProduct->stock_out - $saleProduct->quantity;
            MonthlyStock::whereId($purchaseProduct->id)->update([
                'quantity' => $purchaseProduct->quantity + $saleProduct->quantity,
                'stock_out' => $stock_out > 0 ? $stock_out : 0
            ]);
        }
    }

    /**
     * Handle the Sale "deleted" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function deleted(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "restored" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function restored(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function forceDeleted(Sale $sale)
    {
        //
    }
}
