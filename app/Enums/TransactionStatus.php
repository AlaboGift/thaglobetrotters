<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static SUCCESSFUL()
 * @method static static FAILED()
 */
final class TransactionStatus extends Enum
{
    const PENDING = 'PENDING';
    const SUCCESSFUL = 'SUCCESSFUL';
    const FAILED = 'FAILED';
}
