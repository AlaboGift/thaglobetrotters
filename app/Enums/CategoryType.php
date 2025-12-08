<?php

namespace App\Enums;
use BenSampo\Enum\Enum;

class CategoryType extends Enum
{
    const INTERNATIONAL = 'INTERNATIONAL';
    const NIGERIAN = 'NIGERIAN';
    const CURATED = 'CURATED';

    public static function selectables()
    {
        return [
            self::INTERNATIONAL,
            self::NIGERIAN
        ];
    }
}