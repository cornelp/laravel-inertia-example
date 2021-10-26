<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

final class PositionType extends Enum
{
    use HasValues;

    const FILLER = 1;
    const TEHNIC = 2;
    const SALES = 3;
    const MANAGER = 4;

    protected static $values = [
        self::FILLER => 'Filler',
        self::TEHNIC => 'Tehnic',
        self::SALES => 'Vanzari',
        self::MANAGER => 'Manager',
    ];
}
