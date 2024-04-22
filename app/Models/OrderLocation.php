<?php

namespace App\Models;

use App\Observers\OrderLocationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([OrderLocationObserver::class])]
class OrderLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id' ,'lat', 'lng'
    ];
}
