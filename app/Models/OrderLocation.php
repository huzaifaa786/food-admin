<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id' ,'lat', 'lng'
    ];
}
