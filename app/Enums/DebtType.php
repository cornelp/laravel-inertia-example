<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DebtType extends Enum
{
    use HasValues;

    const RENT = 1;
    const PROVIDER = 2;
    const WARRANTY = 3;
    const SUMMARY = 4;

    protected static $values = [
        self::RENT => 'Chirie',
        self::PROVIDER => 'Furnizor',
        self::WARRANTY => 'Garantie',
        self::SUMMARY => 'Centralizator',
    ];
}
