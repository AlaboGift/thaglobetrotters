<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ActionTypes extends Enum
{
    const CREDIT = 'CREDIT';
    const DEBIT = 'DEBIT';
}
