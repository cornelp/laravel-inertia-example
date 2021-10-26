<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BankType extends Enum
{
    use HasValues;

    const BRD = 1;

    private static $values = [
        self::BRD => 'Brd'
    ];
}
