<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AreaType extends Enum
{
    use HasValues;

    const BC = 1;
    const CJ = 2;
    const SM = 3;
    const BUC = 4;
    const T = 5;

    protected static array $values = [
        self::BC => 'Bacau',
        self::CJ => 'Cluj',
        self::SM => 'SatuMare',
        self::BUC => 'Bucuresti',
        self::T => 'Robert',
    ];
}
