<?php

namespace App\Models;

use App\Enums\DebtDetailType;
use App\Traits\HandlesSearchAndSort;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtDetail extends Model
{
    use HasFactory, CamelCasing, HandlesSearchAndSort;

    protected $fillable = [
        'notes', 'number', 'date',
        'amount', 'paidFromBank', 'type',
        'secondNote'
    ];

    protected $dates = [
        'date'
    ];

    protected $searchFields = [
        'number', 'notes', 'secondNote'
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $model->load('debt');

            $model->isInvoice()
                ? $model->debt->addToInvoicedAmount($model->amount)
                : $model->debt->addToPaidAmount($model->amount);

            $model->debt->save();
        });
    }

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }

    public function isInvoice(): bool
    {
        return intval($this->type) === DebtDetailType::INVOICE;
    }

    public function setAmountAttribute($value)
    {
        return $this->attributes['amount'] = $value * 100;
    }

    public function getAmountAttribute($value)
    {
        return $value / 100;
    }
}
