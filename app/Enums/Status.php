<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class Status extends Enum
{
    const PENDING = 'PENDING';
    const ACTIVE = 'ACTIVE';
    const INACTIVE = 'INACTIVE';
    const DEACTIVATED = 'DEACTIVATED';
    const COMPLETED = 'COMPLETED';
}
