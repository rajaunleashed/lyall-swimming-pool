<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $appends = [
        'products'
    ];

    protected $with = [
        'saleProducts',
        'customer'
    ];

    public function getProductsAttribute() {
        return Product::all();
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class, 'sale_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
