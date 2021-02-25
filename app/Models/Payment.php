<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function setPaymentSourceAttribute() {
        $source = PaymentSource::find($this->attributes['payment_source_id']);
        if ($source) {
            return $this->attributes['payment_source'] = $source->name;
        }
    }
}
