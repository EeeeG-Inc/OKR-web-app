<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PublishStateType extends Enum implements LocalizedEnum
{
    const OptionOne =   0;
    const OptionTwo =   1;
    const OptionThree = 2;
}
