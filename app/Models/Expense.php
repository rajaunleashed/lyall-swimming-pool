<?php

namespace App\Models;

use App\Traits\CommonQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    use CommonQuery;
}
