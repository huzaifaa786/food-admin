<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_item_id', 'extra_id'
    ];
}
