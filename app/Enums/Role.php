<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Role extends Enum implements LocalizedEnum
{
    const ADMIN = 1;
    const COMPANY = 2;
    const DEPARTMENT = 3;
    const MANAGER = 4;
    const MEMBER = 5;
}
