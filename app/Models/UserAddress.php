<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'lat', 'lng', 'address', 'active' , 'building_name', 'building_number', 'floor_number', 'apartment_number', 'user_id'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
}
