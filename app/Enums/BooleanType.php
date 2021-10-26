<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

final class BooleanType extends Enum
{
    use HasValues;

    const AFFIRMATIVE = 1;
    const NEGATIVE = 0;

    protected static $values = [
        self::AFFIRMATIVE => 'Da',
        self::NEGATIVE => 'Nu',
    ];
}
