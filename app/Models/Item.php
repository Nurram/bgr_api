<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    function price() {
        return $this->belongsTo(Price::class);    
    }

    function uom() {
        return $this->belongsTo(UnitOfMaterial::class);
    }

    function orderLines() {
        return $this->hasMany(OrderLines::class);    
    }

}
