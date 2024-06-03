<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLines extends Model
{
    use HasFactory;

    function item()
    {
        return $this->belongsTo(Item::class);    
    }

    function order()
    {
        return $this->belongsTo(Order::class);    
    }
}
