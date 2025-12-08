<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const ADMIN = 'ADMIN';
    const MODERATOR = 'MODERATOR';
    const SUB_ADMIN = 'SUB_ADMIN';
    const CUSTOMER = 'CUSTOMER';
}
