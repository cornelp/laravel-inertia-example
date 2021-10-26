<?php

namespace App\Enums\Traits;

trait HasValues
{
    public static function getDescription($value): string
    {
        return self::$values[$value] ?? reset(self::$values);
    }

    public static function asArrayOfObjects(): array
    {
        return array_map(function ($value, $index) {
            return ['value' => $index, 'text' => $value];
        }, self::$values, array_keys(self::$values));
    }

    public static function asString(): string
    {
        return implode(',', self::asArray());
    }
}
