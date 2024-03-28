<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuCategory extends Model
{
    use HasFactory;

    protected $fillable = [
      'name','restraunt_id'
    ];

    /**
     * Method menu_items
     *
     * @return HasMany
     */
    public function menu_items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->with('extras');
    }
}
