<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function loadSalesRelations()
    {
        $customers = Customer::all();
        $products = Product::all();

        return response()->json([
            'customers' => $customers,
            'products' => $products
        ]);
    }
}
