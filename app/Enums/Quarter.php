<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class Quarter extends Enum implements LocalizedEnum
{
    // quartes.id が 1 のレコードは全会社共通の通年とする
    const FULL_YEAR_ID = 1;

    // 四半期区分
    const QUARTER_FULL_YEAR = 0;
    const FIRST_QUARTER = 1;
    const SECOND_QUARTER = 2;
    const THIRD_QUARTER = 3;
    const FOURTH_QUARTER = 4;
}
