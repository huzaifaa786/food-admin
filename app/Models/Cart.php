<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restraunt_id',
        'total_amount',
        'total_quantity',
    ];

    /**
     * Method items
     *
     * @return HasMany
     */
    public function items() : HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Method calculateTotals
     *
     * @return void
     */
    public function calculateTotals()
    {
        $this->total_amount = $this->items->sum('subtotal');
        $this->total_quantity = $this->items->sum('quantity');
        $this->save();
    }
}