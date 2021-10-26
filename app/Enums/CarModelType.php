<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CarModelType extends Enum
{
    use HasValues;

    const DACIA_LOGAN = 1;
    const DACIA_DOKKER = 2;

    private static $values = [
        self::DACIA_LOGAN => 'Dacia Logan',
        self::DACIA_DOKKER => 'Dacia Dokker',
    ];
}
