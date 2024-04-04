<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'menu_item_id', 'notes', 'quantity', 'subtotal'
    ];

    /**
     * Method menu_item
     *
     * @return BelongsTo
     */
    public function menu_item(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * Method cart
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Method extras
     *
     * @return HasMany
     */
    public function extras(): HasMany
    {
        return $this->hasMany(OrderItemExtra::class);
    }
}
