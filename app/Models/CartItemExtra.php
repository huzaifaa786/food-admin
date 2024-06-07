<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItemExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_item_id',
        'extra_id',
        'quantity',
    ];

    /**
     * Method extra
     *
     * @return BelongsTo
     */
    public function extra(): BelongsTo
    {
        return $this->belongsTo(Extra::class);
    }
}
