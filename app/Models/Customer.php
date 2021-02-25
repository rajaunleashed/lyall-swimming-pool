<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $with = [
        'route'
    ];

    public function route() {
        return $this->belongsTo(Route::class);
    }
}
