<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $appends = [
        'original_price',
        'final_price'
    ];

    protected $fillable = [
        'name',
        'restraunt_id',
        'description',
        'ar_desc',
        'image',
        'image2',
        'image3',
        'price',
        'menu_category_id',
        'discount',
        'available',
        'discount_till_date',
        'discount_days',
    ];

    protected $casts = [
        'available' => 'boolean'
    ];

    public function getPriceAttribute($value)
    {
        $currentDate = now()->toDateString();

        if ($this->discount && $this->discount_till_date && $currentDate <= $this->discount_till_date) {
            return round($value - ($value * ($this->discount / 100)), 2);
        }

        // If discount has expired, reset to original price
        return round($this->attributes['price'], 2);
    }

    public function getOriginalPriceAttribute()
    {
        $currentDate = now()->toDateString();

        if ($this->discount && $this->discount_till_date && $currentDate <= $this->discount_till_date) {
            return round($this->attributes['price'], 2);
        }

        return null; // No discount applied
    }

    public function getFinalPriceAttribute()
    {
        return $this->price; // This will return the final price, which is either discounted or original
    }

    /**
     * Method toggleAvailable
     *
     * @param bool $available [explicite description]
     *
     * @return void
     */
    public function toggleAvailable($availble)
    {
        $this->available = $availble;
        $this->save();
    }

    /**
     * Method extras
     *
     * @return HasMany
     */
    public function extras(): HasMany
    {
        return $this->hasMany(Extra::class);
    }

    public function menu_category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }
    public function restraunt(): BelongsTo
    {
        return $this->belongsTo(Restraunt::class, 'restraunt_id');
    }

    /**
     * Method setImageAttribute
     *
     * @param $value $value [explicite description]
     *
     * @return void
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => asset($value),
            set: fn(string $value) => ImageHelper::saveImageFromApi($value, 'images/menus')
        );
    }

    protected function image2(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => asset($value),
            set: fn(string $value) => ImageHelper::saveImageFromApi($value, 'images/menus')
        );
    }

    protected function image3(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => asset($value),
            set: fn(string $value) => ImageHelper::saveImageFromApi($value, 'images/menus')
        );
    }

    public function orderitem()
    {
        return $this->hasMany(OrderItem::class);
    }
}
