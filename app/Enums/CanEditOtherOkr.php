<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class CanEditOtherOkr extends Enum implements LocalizedEnum
{
    public const CAN_NOT_EDIT_OTHER_OKR = 0;
    public const CAN_EDIT_OTHER_OKR = 1;
}
