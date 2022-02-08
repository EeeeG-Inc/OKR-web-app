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

    public static function getRolesInWhenCreateUser(int $myRole, bool $isMaster = false): array
    {
        $results = [];

        foreach (self::getValues() as $value) {
            if (($myRole === self::COMPANY) && ($value === self::COMPANY) && ($isMaster === true)) {
                $results[$value] = self::getLocalizedDescription($value);
            }

            if ($value > $myRole) {
                $results[$value] = self::getLocalizedDescription($value);
            }
        }
        return $results;
    }

    public static function getRolesInWhenCreateUserIfNoDepartment(int $myRole, bool $isMaster = false): array
    {
        $results = [];

        foreach (self::getValues() as $value) {
            if (($myRole === self::COMPANY) && ($value === self::COMPANY) && ($isMaster === true)) {
                $results[$value] = self::getLocalizedDescription($value);
            }

            if (($value > $myRole) && ($value <= self::DEPARTMENT)) {
                $results[$value] = self::getLocalizedDescription($value);
            }
        }
        return $results;
    }

    public static function getRolesInWhenUpdateUser(int $myRole): array
    {
        $results = [];

        switch ($myRole) {
            case Role::MEMBER:
            case Role::MANAGER:
                $results[Role::MEMBER] = self::getLocalizedDescription(Role::MEMBER);
                $results[Role::MANAGER] = self::getLocalizedDescription(Role::MANAGER);
                break;
        }

        return $results;
    }
}
