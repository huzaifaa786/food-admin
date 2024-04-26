<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'payment_intent',
        'status',
        'has_rating'
    ];

    /**
     * Method location
     *
     * @return HasOne
     */
    public function location() : HasOne
    {
        return $this->hasOne(OrderLocation::class);
    }

    /**
     * Method user
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
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
