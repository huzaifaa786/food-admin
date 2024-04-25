<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restraunt_id',
        'order_id',
        'driver_id',
        'title',
        'body',
        'seen'
    ];

    protected $casts = [
        'seen' => 'boolean'
    ];
}
