<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'restraunt_id',
        'description',
        'image',
        'price',
        'menu_category_id',
        'discount',
        'available',
        'discount_till_date'
    ];

    /**
     * Method extras
     *
     * @return HasMany
     */
    public function extras(): HasMany
    {
        return $this->hasMany(Extra::class);
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
            get: fn (string $value) => asset($value),
            set: fn (string $value) => ImageHelper::saveImageFromApi($value, 'images/menus')
        );
    }
}