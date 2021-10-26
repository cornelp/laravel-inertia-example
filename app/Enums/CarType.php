<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

final class CarType extends Enum
{
    use HasValues;

    const CAR = 1;
    const VAN = 2;

    protected static $values = [
        1 => 'Car',
        2 => 'Van'
    ];
}
