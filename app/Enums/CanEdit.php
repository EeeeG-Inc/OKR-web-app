<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class CanEdit extends Enum implements LocalizedEnum
{
    public const CAN_NOT_EDIT = 0;
    public const CAN_EDIT = 1;
}
