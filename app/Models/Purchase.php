<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    /*
     * @param $Item
     * @param $previousItems
     * @return void
     *
     * */

    public static function resolveStock($items, $previousItems = null) {
        for ($i = 0; $i < count($items); $i++) {
            $availableStockProducts = self::getAvailableStockProducts($items[$i]['product_id']);
            self::manageStock($availableStockProducts, $items[$i]['quantity'], $items[$i]['sale_id'], $previousItems);
        }
    }


    /*
     * @param $product_id
     * @return \App\Models\Purchase
     *
     * */

    public static function getAvailableStockProducts($product_id)
    {
        return Purchase::where('stock_in', '>', 0)->whereProductId($product_id)->get();
    }


    /*
     * @param array \App\Models\Purchase
     * @return void
     *
     * */

    public static function manageStock($availableStockProducts, $quantity, $saleID, $previousItems = null)
    {
        foreach ($availableStockProducts as $item) {
            $stock_in = 0;
            $continue = false;
            $availableStock = $item->stock_in;
            $stock_out = $item->stock_out;
            if (!is_null($previousItems)) {
                $previousItem = $previousItems->where('sale_id', $saleID);
                $previousItem = $previousItem->where('product_id', $item->product_id);
                $previousItem->all();
                if (count($previousItem)) {
                    $availableStock = $availableStock + $previousItem[0]->quantity;
                    $stock_out = 0;
                }
            }

            if($availableStock < $quantity) {
                $quantity = $quantity - $item->stock_in; //50 - 5 = 45
                $stock_out = $stock_out + $availableStock;  //45 + 5 = 50
                $stock_in = 0;
                $continue = true;
            } else {
                $stock_in = $availableStock - $quantity; //50 - 45 = 5
                $stock_out = $stock_out + $quantity;
                $continue = false;
            }
            Purchase::whereId($item->id)->update([
               'stock_in' => $stock_in,
               'stock_out' => $stock_out
            ]);

            if (!$continue) {
                break;
            }
        }
    }
}
