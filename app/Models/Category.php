<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ar_name',
        'image'
    ];

    public function getImageAttribute($value)
    {
        return asset($value);
    }

    /**
     * Method restaurants
     *
     * @return HasMany
     */
    public function restaurants(): HasMany
    {
        return $this->hasMany(Restraunt::class)->whereHas('menu_categories');
    }
}
