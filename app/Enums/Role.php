<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Ramsey\Uuid\Type\Integer;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
class Role extends Enum implements LocalizedEnum
{
    const ADMIN = 1;
    const COMPANY = 2;
    const DEPARTMENT = 3;
    const MANAGER = 4;
    const MEMBER = 5;

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
