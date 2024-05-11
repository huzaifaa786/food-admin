<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'menu_item_id', 'notes', 'quantity', 'subtotal', 'ar_desc'
    ];

    /**
     * Method menu_item
     *
     * @return BelongsTo
     */
    public function menu_item() : BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * Method cart
     *
     * @return BelongsTo
     */
    public function cart() : BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Method extras
     *
     * @return HasMany
     */
    public function extras() : HasMany
    {
        return $this->hasMany(CartItemExtra::class);
    }

    /**
     * Method calculateSubtotal
     *
     * @return void
     */
    public function calculateSubtotal()
    {
        $subtotal = $this->quantity * $this->menu_item->price;

        foreach ($this->extras as $cartExtra) {
            $subtotal += $cartExtra->extra->price;
        }
        $this->subtotal = $subtotal;
        $this->save();
    }
}
