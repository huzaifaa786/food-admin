<?php

namespace App\Models;

use Carbon\Carbon;
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
        'ar_body',
        'status',
        'seen'
    ];

    protected $casts = [
        'seen' => 'boolean'
    ];

    public function getCreatedAt($value)
    {
        return Carbon::parse($value);
    }
}
