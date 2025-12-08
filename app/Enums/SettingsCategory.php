<?php

namespace App\Enums;
use BenSampo\Enum\Enum;

class SettingsCategory extends Enum
{
    const BASIC = 'BASIC';
    const SOCIAL = 'SOCIAL';
    const SMTP = 'SMTP';
    const LANDING = 'LANDING';
}