<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DeliveryStatus extends Enum
{
    const PENDING = 'PENDING';
    const WITHHELD = 'WITHHELD';
    const CONFIRMED = 'CONFIRMED';
    const DISPATCHED = 'DISPATCHED';
    const DELIVERED = 'DELIVERED';
    const CANCELLED = 'CANCELLED';
}
