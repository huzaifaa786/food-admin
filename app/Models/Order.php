<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restraunt_id',
        'total_amount',
        'total_quantity',
        'user_address_id',
        'driver_id',
    ];

    /**
     * Method items
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Method restraunt
     *
     * @return BelongsTo
     */
    public function restraunt(): BelongsTo
    {
        return $this->belongsTo(Restraunt::class);
    }
}
