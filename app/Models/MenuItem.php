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
    protected $appends = ['original_price'];

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

        if (
            $this->discount &&
            $this->discount_till_date &&
            $currentDate <= $this->discount_till_date
        ) {
            return $value - ($value * ($this->discount / 100));
        }
        return $value;
    }

    public function getOriginalPriceAttribute()
    {
        $currentDate = now()->toDateString();

        if (
            $this->discount &&
            $this->discount_till_date &&
            $currentDate <= $this->discount_till_date
        ) {
            return round($this->attributes['price'] / (1 - $this->discount / 100), 2);
        } else {
            $this->original_price = null;
            $this->discount = 0.0;
            $this->discount_till_date = null;
            $this->discount_days = '0';
        }

        return $this->attributes['price']; // Return null if there's no discount
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
