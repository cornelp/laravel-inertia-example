<?php

namespace App\Models;

use App\Traits\HandlesSearchAndSort;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory, CamelCasing, HandlesSearchAndSort;

    protected $fillable = [
        'number', 'isActive', 'serial', 'notes'
    ];

    protected $casts = [
        'isActive' => true
    ];

    protected $searchFields = [
        'number', 'serial', 'notes',
        'agent.name'
    ];

    public static function boot()
    {
        parent::boot();

        self::saved(function ($model) {
            // if we want to set the model as inactive
            // we need to release the agent
            if (!$model->isActive) {
                optional($model->agent()->first())->update(['phone' => null]);
            }
        });
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function scopeActives($q)
    {
        $q->whereIsActive(true);
    }

    public function scopeAvailable($q)
    {
        $q->whereDoesntHave('agent');
    }
}
