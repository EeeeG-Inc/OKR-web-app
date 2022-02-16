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

    public static function getFontAwesome($priority): string
    {
        switch ($priority) {
            case self::P0:
                return '<i class="fa-solid fa-battery-full fa-fw fa-lg"></i>';
            case self::P1:
                return '<i class="fa-solid fa-battery-three-quarters fa-fw fa-lg"></i>';
            case self::P2:
                return '<i class="fa-solid fa-battery-half fa-fw fa-lg"></i>';
            case self::P3:
                return '<i class="fa-solid fa-battery-quarter fa-fw fa-lg"></i>';
            case self::P4:
                return '<i class="fa-solid fa-battery-empty fa-fw fa-lg"></i>';
        }
    }
}
