<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CityType extends Enum
{
    use HasValues;

    const BACAU = 1;
    const VASLUI = 2;

    protected static $values = [
        self::BACAU => 'Bacau',
        self::VASLUI => 'Vaslui',
    ];
}
