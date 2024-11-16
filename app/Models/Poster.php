<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Poster extends Model
{
    use HasFactory;

    protected $fillable = [
        'restraunt_id', 'poster'
    ];

    protected function poster(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset($value),
            set: fn (string $value) => ImageHelper::saveImageFromApi($value, 'images/poster')
        );
    }
    
}
