<?php

namespace App\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarInsurance extends Model
{
    use HasFactory, CamelCasing;

    protected $fillable = [
        'car', 'date', 'issuer',
        'class', 'amount', 'validityInMonths'
    ];

    protected $dates = [
        'date'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($insurance) {
            $insurance->car()->update([
                'insuranceTillDate' => $insurance->date->addMonths($insurance->validityInMonths)
            ]);
        });
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function setCarAttribute($attr)
    {
        $this->attributes['car_id'] = is_object($attr) ? $attr->id : (is_array($attr) ? $attr['id'] : $attr);
    }
}
