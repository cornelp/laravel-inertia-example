<?php

namespace App\Models;

use App\Traits\HandlesSearchAndSort;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarReview extends Model
{
    use HasFactory, CamelCasing, HandlesSearchAndSort;

    protected $fillable = [
        'car', 'agent', 'date',
        'invoiceDate', 'type', 'mileage',
        'amount', 'observations'
    ];

    protected $dates = [
        'date', 'invoiceDate'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function setCarAttribute($attr)
    {
        $this->attributes['car_id'] = is_object($attr) ? $attr->id : (is_array($attr) ? $attr['id'] : $attr);
    }

    public function setTypeAttribute($attr)
    {
        $this->attributes['type_id'] = is_object($attr) ? $attr->id : (is_array($attr) ? $attr['id'] : $attr);
    }

    public function setAgentAttribute($attr)
    {
        $this->attributes['agent_id'] = is_object($attr) ? $attr->id : (is_array($attr) ? $attr['id'] : $attr);
    }
}
