<?php

namespace App\Enums;
use BenSampo\Enum\Enum;

class EventTicketType extends Enum
{
    const BASIC = 'BASIC';
    const STANDARD = 'STANDARD';
    const PREMIUM = 'PREMIUM';
}