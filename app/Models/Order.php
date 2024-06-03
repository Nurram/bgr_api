<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    function orderLines() {
        return $this->hasMany(OrderLines::class);    
    }

    function payment() {
        return $this->belongsTo(PaymentMethod::class);
    }
    
    function privilege() {
        return $this->belongsTo(PaymentMethod::class);
    }
}
