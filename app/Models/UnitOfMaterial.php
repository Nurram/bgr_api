<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOfMaterial extends Model
{
    use HasFactory;

    function items()
    {
        return $this->hasMany(Item::class);    
    }
}
