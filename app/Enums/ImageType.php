<?php

namespace App\Enums;
use BenSampo\Enum\Enum;

class ImageType extends Enum
{
    const EVENT = 'EVENT';
    const ACTIVITY = 'ACTIVITY';
    const GALLERY = 'GALLERY';
    const ACHIEVEMENT = 'ACHIEVEMENT';
    const BANNER = 'BANNER';
    const USER = 'USER';
    const CAREER = 'CAREER';
}