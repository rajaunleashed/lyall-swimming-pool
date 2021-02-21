<?php

namespace App\Observers;

use App\Models\Purchase;
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
            $purchaseProduct = Purchase::whereProductId($saleProduct->product_id)->latest()->first();
            $stock_out = $purchaseProduct->stock_out - $saleProduct->quantity;
            Purchase::whereId($purchaseProduct->id)->update([
               'stock_in' => $purchaseProduct->stock_in + $saleProduct->quantity,
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
