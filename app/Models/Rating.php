<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'restraunt_id', 'order_id', 'rating', 'notes'
    ];
    public function resturant(){
        return $this->belongsTo(Restraunt::class);
    }
}