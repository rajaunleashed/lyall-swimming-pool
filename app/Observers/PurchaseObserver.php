<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class PurchaseObserver
{
    /**
     * Handle the Purchase "creating" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function saving(Purchase $purchase)
    {
        if ($purchase->product_id) {
            $product = Product::find($purchase->product_id);
            $purchase->product_name = $product->name;
        }

        if ($purchase->supplier_id) {
            $supplier = Supplier::find($purchase->supplier_id);
            $purchase->supplier_name = $supplier->name;

        }

    }


    /**
     * Handle the Purchase "created" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function created(Purchase $purchase)
    {
        //
    }


    /**
     * Handle the Purchase "updated" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function updated(Purchase $purchase)
    {
    }

    /**
     * Handle the Purchase "deleted" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function deleted(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the Purchase "restored" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function restored(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the Purchase "force deleted" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function forceDeleted(Purchase $purchase)
    {
        //
    }
}
