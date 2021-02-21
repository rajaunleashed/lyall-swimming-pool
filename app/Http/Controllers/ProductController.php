<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class ProductController extends VoyagerBaseController
{
    public function all() {
        return response()->json([
            'products' => Product::all()
        ]);
    }
}
