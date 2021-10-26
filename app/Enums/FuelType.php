<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FuelType extends Enum
{
    use HasValues;

    const GAS = 1;
    const DIESEL = 2;

    protected static $values = [
        self::GAS => 'Benzina',
        self::DIESEL => 'Motorina',
    ];
}
