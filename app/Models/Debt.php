<?php

namespace App\Models;

use App\Traits\HandlesSearchAndSort;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory, CamelCasing, HandlesSearchAndSort;

    protected $fillable = [
        'area', 'city', 'name',
        'notes', 'taxCode', 'bankAccount',
        'bank', 'isActive', 'type'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $searchFields = [
        'name', 'bankAccount', 'tax_code'
    ];

    public function addToInvoicedAmount($value)
    {
        $this->attributes['invoiced_amount'] += $value * 100;
        $this->attributes['balance'] += $value * 100;
    }

    public function addToPaidAmount($value)
    {
        $this->attributes['paid_amount'] += $value * 100;
        $this->attributes['balance'] -= $value * 100;
    }

    public function getBalanceAttribute()
    {
        return $this->attributes['balance'] / 100;
    }

    public function getPaidAmountAttribute()
    {
        return $this->attributes['paid_amount'] / 100;
    }

    public function getInvoicedAmountAttribute()
    {
        return $this->attributes['invoiced_amount'] / 100;
    }

    public function details()
    {
        return $this->hasMany(DebtDetail::class);
    }
}
