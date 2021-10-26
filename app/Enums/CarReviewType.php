<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CarReviewType extends Enum
{
    use HasValues;

    const REPARATION = 1;
    const REVIEW = 2;
    const COMBINED = 3;

    private static $values = [
        self::REPARATION => 'Reparatie',
        self::REVIEW => 'Revizie',
        self::COMBINED => 'Revizie/Reparatie',
    ];
}
