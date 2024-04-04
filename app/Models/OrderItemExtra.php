<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id', 'extra_id'
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
