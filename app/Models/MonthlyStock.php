<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyStock extends Model
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
        return self::where('quantity', '>', 0)->whereProductId($product_id)->get();
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
            $availableQuantity = $item->quantity;
            $stock_out = $item->stock_out;
            if (!is_null($previousItems)) {
                $previousItem = $previousItems->where('sale_id', $saleID);
                $previousItem = $previousItem->where('product_id', $item->product_id);
                $previousItem->all();
                if (count($previousItem)) {
                    $availableQuantity = $availableQuantity + $previousItem[0]->quantity;
                    $stock_out = 0;
                }
            }

            if($availableQuantity < $quantity) {
                $quantity = $quantity - $item->quantity; //50 - 5 = 45
                $stock_out = $stock_out + $availableQuantity;  //45 + 5 = 50
                $stock_in = 0;
                $continue = true;
            } else {
                $stock_in = $availableQuantity - $quantity; //50 - 45 = 5
                $stock_out = $stock_out + $quantity;
                $continue = false;
            }
            self::whereId($item->id)->update([
                'quantity' => $stock_in,
                'stock_out' => $stock_out
            ]);

            if (!$continue) {
                break;
            }
        }
    }
}
