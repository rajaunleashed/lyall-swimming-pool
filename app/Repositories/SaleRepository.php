<?php


namespace App\Repositories;


use App\Models\Customer;
use App\Models\Sale;

class SaleRepository
{
    public function store($request) {

        $sale = new Sale();
        $sale->customer_id = $request->customer_id;
        $sale->customer_name = Customer::whereId($request->customer_id)->value('name');
//        $sale->paid_status = $request->paid_status;
        $sale->save();

        return $sale;
    }

    public function update($request, $id) {

        $sale = Sale::find($id);
        $sale->customer_id = $request->customer_id;
        $sale->customer_name = Customer::whereId($request->customer_id)->value('name');
        $sale->save();

        return $sale;
    }
}
