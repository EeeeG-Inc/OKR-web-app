<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
class Role extends Enum implements LocalizedEnum
{
    public const ADMIN = 1;

    public const COMPANY = 2;

    public const DEPARTMENT = 3;

    public const MANAGER = 4;

    public const MEMBER = 5;

    public static function getRolesInWhenCreateUser(int $myRoleVal, bool $isMaster = false): array
    {
        $results = [];

        foreach (self::getValues() as $value) {
            if (($myRoleVal === self::COMPANY) && ($value === self::COMPANY) && ($isMaster === true)) {
                $results[$value] = self::getLocalizedDescription($value);
            }

            if ($value > $myRoleVal) {
                $results[$value] = self::getLocalizedDescription($value);
            }
        }
        return $results;
    }

    public static function getRolesInWhenCreateUserIfNoDepartment(int $myRoleVal, bool $isMaster = false): array
    {
        $results = [];

        foreach (self::getValues() as $value) {
            if (($myRoleVal === self::COMPANY) && ($value === self::COMPANY) && ($isMaster === true)) {
                $results[$value] = self::getLocalizedDescription($value);
            }

            if (($value > $myRoleVal) && ($value <= self::DEPARTMENT)) {
                $results[$value] = self::getLocalizedDescription($value);
            }
        }
        return $results;
    }
}
