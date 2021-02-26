<?php


namespace App\Repositories;


use App\Models\Product;
use App\Models\SaleProduct;

class SaleProductsRepository
{
    protected $sale_id;
    /* @handler
     * @param $request
     * @param $sale_id
     * $param $callable
     * @return void
     * */
    public function store($request, $sale_id, callable $callable)
    {
        $this->sale_id = $sale_id;
        $items = $this->collectItems($request);
        SaleProduct::insert($items);

        return $callable($items);
    }

    /* @handler
     * @param $request
     * @param $sale_id
     * $param $callable
     * @return void
     * */
    public function update($request, $sale_id, callable $callable)
    {
        $this->sale_id = $sale_id;
        $previousItems = SaleProduct::whereSaleId($sale_id)->get();
        SaleProduct::whereSaleId($sale_id)->delete();
        $items = $this->collectItems($request);
        SaleProduct::insert($items);

        $data = [
          'items' => $items,
          'previousItems' => $previousItems
        ];

        return $callable($data);
    }

    public function collectItems($request) {
        $items = [];
        foreach ($request->input('items') as $item) {
            $product = Product::find($item['product_id']);
            $item = [
                'sale_id' => $this->sale_id,
                'product_id' => $item['product_id'],
                'price' => $product->trade_price,
                'discount' => $item['discount'] ?? 0,
                'quantity' => $item['quantity'],
                'total_price' => $item['quantity'] * $product->trade_price - $item['discount']
            ];
            $items[] = $item;
        }

        return $items;
    }


    public function totalAmount($id)
    {
        return SaleProduct::whereSaleId($id)->sum('total_price');
    }
}
