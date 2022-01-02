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
    const QUARTER_ONE = 1;
    const QUARTER_TWO = 2;
    const QUARTER_THREE = 3;
    const QUARTER_FOUR = 4;
}
