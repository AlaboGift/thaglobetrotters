<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SALES()
 *
 */
final class PaymentMethod extends Enum
{
    const BANK_TRANSFER = 'BANK_TRANSFER';
    const WALLET = 'WALLET';
    const PAYSTACK = 'PAYSTACK';
    const PAYSTACK_AND_WALLET = 'PAYSTACK_AND_WALLET';
}
