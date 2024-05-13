<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

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
        'ar_body',
        'status',
        'seen'
    ];

    protected $casts = [
        'seen' => 'boolean'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
