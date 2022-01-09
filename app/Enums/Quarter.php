<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class Quarter extends Enum implements LocalizedEnum
{
    // quartes.id が 1 のレコードは全会社共通の通年とする
    public const FULL_YEAR_ID = 1;

    // 四半期区分
    public const QUARTER_FULL_YEAR = 0;

    public const FIRST_QUARTER = 1;

    public const SECOND_QUARTER = 2;

    public const THIRD_QUARTER = 3;

    public const FOURTH_QUARTER = 4;
}
