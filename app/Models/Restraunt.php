<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    public function setLogoAttribute($value)
    {
        if ($value)
            return $this->attributes['logo'] = ImageHelper::saveImageFromApi($value, 'images/restraunt/logo');
        return null;
    }

    /**
     * Method setCoverAttribute
     *
     * @param $value $value [explicite description]
     *
     * @return void
     */
    public function setCoverAttribute($value)
    {
        if ($value)
            return $this->attributes['cover'] = ImageHelper::saveImageFromApi($value, 'images/restraunt/cover');
        return null;
    }

    /**
     * Method setLicenseAttribute
     *
     * @param $value $value [explicite description]
     *
     * @return void
     */
    public function setLicenseAttribute($value)
    {
        if ($value)
            return $this->attributes['license'] = ImageHelper::saveImageFromApi($value, 'images/restraunt/license');
        return null;
    }
}
