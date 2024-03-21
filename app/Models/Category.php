<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];


    public function setImageAttribute($value)
    {
        if ($value)
            return $this->attributes['image'] = ImageHelper::saveImageFromApi($value, 'images/categories');
        return null;
    }
}
