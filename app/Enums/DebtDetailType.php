<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;
use BenSampo\Enum\Enum;

final class DebtDetailType extends Enum
{
    use HasValues;

    const INVOICE = 1;
    const PAYMENT = 2;

    protected static $values = [
        self::INVOICE => 'Factura',
        self::PAYMENT => 'Plata',
    ];
}
