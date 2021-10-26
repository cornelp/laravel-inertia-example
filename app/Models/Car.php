<?php

namespace App\Models;

use App\Traits\HandlesSearchAndSort;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory, CamelCasing, HandlesSearchAndSort;

    protected $fillable = [
        'area', 'city', 'licenseNo',
        'model', 'agent', 'fuel',
        'productionYear', 'purchaseYear', 'type',
        'engineCapacity', 'revisionInKm', 'horsePower',
        'chassis', 'insuranceTillDate', 'roadTaxTillDate',
        'tehnicalInspectionTillDate', 'fuelCard', 'fuelPin',
        'needsRoadTax', 'distributionInYears',
        'distributionInKm',
    ];

    protected $dates = [
        'insurance_till_date', 'road_tax_till_date', 'tehnical_inspection_till_date'
    ];

    protected $casts = [
        'needs_road_tax' => 'boolean'
    ];

    protected $searchFields = [
        'licenseNo', 'chassis', 'model',
        'agent.name'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->insuranceTillDate = $model->insuranceTillDate ?? now();
            $model->roadTaxTillDate = $model->roadTaxTillDate ?? now();
            $model->tehnicalInspectionTillDate = $model->tehnicalInspectionTillDate ?? now();
        });
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function fuelSupplies()
    {
        return $this->hasMany(Fuel::class);
    }

    public function reviews()
    {
        return $this->hasMany(CarReview::class);
    }

    public function insurances()
    {
        return $this->hasMany(CarInsurance::class);
    }

    public function setAgentAttribute($attr)
    {
        $this->attributes['agent_id'] = is_object($attr) ? $attr->id : (is_array($attr) ? $attr['id'] : $attr);
    }

    public function getConsumptionAttribute()
    {
        return array_key_exists('consumption', $this->attributes) ? $this->attributes['consumption'] / 100 : 0;
    }

    public function adjustConsumption(?Fuel $fuel = null): self
    {
        $fuelSupplies = $this->fuelSupplies()
            ->get(['date', 'consumption'])
            ->when($fuel, fn ($coll) => $coll->push($fuel->only('date', 'consumption')))
            ->sortByDesc('date');

        if ($consumption = $fuelSupplies->sum('consumption')) {
            $this->attributes['consumption'] = $consumption / ($fuelSupplies->count() - 1) * 100;
        }

        return $this;
    }
}
