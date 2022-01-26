<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
class Priority extends Enum implements LocalizedEnum
{
    public const P0 = 0;
    public const P1 = 1;
    public const P2 = 2;
    public const P3 = 3;
    public const P4 = 4;

    public static function getFlipLocalizedDescription(): array
    {
        $results = [
            null => '優先度を選択してください',
        ];

        foreach (array_flip(self::asArray()) as $key => $_) {
            $results[$key] = self::getLocalizedDescription($key);
        }

        return $results;
    }
}
