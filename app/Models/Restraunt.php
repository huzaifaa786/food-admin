<?php

namespace App\Models;

use App\Enums\RestrauntStatus;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Restraunt extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'logo',
        'cover',
        'license',
        'password',
        'lat',
        'lng',
        'radius',
        'status',
        'fcm_token',
        'category_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Method setPasswordAttribute
     *
     * @param $value $value [explicite description]
     *
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Method setLogoAttribute
     *
     * @param $value $value [explicite description]
     *
     * @return void
     */
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset($value),
            set: fn (string $value) => ImageHelper::saveImageFromApi($value, 'images/restraunt/logo')
        );
    }

    /**
     * Method setCoverAttribute
     *
     * @param $value $value [explicite description]
     *
     * @return void
     */
    protected function cover(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset($value),
            set: fn (string $value) => ImageHelper::saveImageFromApi($value, 'images/restraunt/cover')
        );
    }

    /**
     * Method setLicenseAttribute
     *
     * @param $value $value [explicite description]
     *
     * @return void
     */
    protected function license(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset($value),
            set: fn (string $value) => ImageHelper::saveImageFromApi($value, 'images/restraunt/license')
        );
    }

    /**
     * Method category
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Method status
     *
     * @return Attribute
     */
    public function getStatusAttribute($value)
    {
        return RestrauntStatus::from($value)->name;
    }

    /**
     * Method categories
     *
     * @return HasMany
     */
    public function menu_categories(): HasMany
    {
        return $this->hasMany(MenuCategory::class)->with('menu_items');
    }

    public function resturantorders()
    {
        return $this->hasMany(Order::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function rider(){
        return $this->hasMany(Driver::class);
    }
}
