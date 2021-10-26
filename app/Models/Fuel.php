<?php

namespace App\Models;

use App\Traits\HandlesSearchAndSort;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory, CamelCasing, HandlesSearchAndSort;

    protected $fillable = [
        'date', 'car', 'agent',
        'mileage', 'amount', 'liters'
    ];

    protected $dates = [
        'date'
    ];

    protected $searchFields = [
        'amount', 'mileage', 'agent.name'
    ];

    public static function boot()
    {
        parent::boot();

        self::deleted(fn ($model) => $model->car->adjustConsumption()->save());

        self::creating(function ($model) {
            $model->load('car');

            $model->calculateConsumption();

            $model->car
                ->adjustConsumption($model)
                ->save();
        });
    }

    public function setCarAttribute($attr)
    {
        $this->attributes['car_id'] = is_object($attr) ? $attr->id : (is_array($attr) ? $attr['id'] : $attr);
    }

    public function setAgentAttribute($attr)
    {
        $this->attributes['agent_id'] = is_object($attr) ? $attr->id : (is_array($attr) ? $attr['id'] : $attr);
    }

    public function getConsumptionAttribute()
    {
        return array_key_exists('consumption', $this->attributes) ? $this->attributes['consumption'] / 100 : 0;
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function calculateConsumption(): self
    {
        if (!$this->relationLoaded('car')) {
            $this->load('car');
        }

        $latestFuelSupply = $this->car
            ->fuelSupplies()
            ->latest()
            ->first();

        if ($latestFuelSupply) {
            // this is going to be stored as integer
            $this->attributes['consumption'] = $this->liters / ($this->mileage - ($latestFuelSupply->mileage ?? 0)) * 100 * 100;
        }

        return $this;
    }
}
