<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RedisKeyType extends Enum
{
    const COUNT = 'count';
    const AMOUNT = 'amount';
}
