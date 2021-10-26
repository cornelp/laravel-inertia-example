<?php

namespace App\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HandlesSearchAndSort;

class Agent extends Model
{
    use HasFactory, CamelCasing, SoftDeletes, HandlesSearchAndSort;

    protected $fillable = [
        'contractNo', 'name', 'area',
        'hireDate', 'birthDate', 'cnp',
        'icSerial', 'icNumber', 'address',
        'icCity', 'position', 'cor',
        'resignationDate', 'phone'
    ];

    protected $dates = [
        'birthDate', 'hireDate', 'resignationDate'
    ];

    protected $searchFields = [
        'name', 'icNumber', 'icCity',
        'contractNo', 'phone.number'
    ];

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }

    public function car()
    {
        return $this->hasOne(Car::class);
    }

    public function fuelSupplies()
    {
        return $this->hasMany(Fuel::class);
    }

    public function setPhoneAttribute($attr)
    {
        $this->attributes['phone_id'] = is_object($attr) ? $attr->id : (is_array($attr) ? $attr['id'] : $attr);
    }

    public function scopeActives($query)
    {
        $query->whereNull('resignation_date');
    }
}
