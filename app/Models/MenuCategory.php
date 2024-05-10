<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuCategory extends Model
{
  use HasFactory;

  protected $fillable = [
    'name', 'restraunt_id', 'ar_name'
  ];

  /**
   * Method menu_items
   *
   * @return HasMany
   */

   public function restraunt(): BelongsTo
   {
       return $this->belongsTo(Restraunt::class);
   }

  public function menu_items(): HasMany
  {
    return $this->hasMany(MenuItem::class)->where('available', true)->with('extras');
  }
}
