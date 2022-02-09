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

    public static function getRolesWhenCreateUser(int $myRole, bool $isMaster = false): array
    {
        $results = [];

        foreach (self::getValues() as $role) {
            // 親会社のみが会社アカウント作成可能
            if (($myRole === self::COMPANY) && ($role === self::COMPANY) && ($isMaster === true)) {
                $results[$role] = self::getLocalizedDescription($role);
            }

            // マネージャはマネージャアカウントも作成可能
            if (($myRole === self::MANAGER) && ($role === self::MANAGER)) {
                $results[$role] = self::getLocalizedDescription($role);
            }

            if ($role > $myRole) {
                $results[$role] = self::getLocalizedDescription($role);
            }
        }
        return $results;
    }

    public static function getRolesWhenCreateUserIfNoDepartment(int $myRole, bool $isMaster = false): array
    {
        $results = [];

        foreach (self::getValues() as $role) {
            // 親会社のみが会社アカウント作成可能
            if (($myRole === self::COMPANY) && ($role === self::COMPANY) && ($isMaster === true)) {
                $results[$role] = self::getLocalizedDescription($role);
            }

            if (($role > $myRole) && ($role <= self::DEPARTMENT)) {
                $results[$role] = self::getLocalizedDescription($role);
            }
        }
        return $results;
    }

    public static function getRolesWhenUpdateUser(int $myRole): array
    {
        $results = [];

        switch ($myRole) {
            case Role::COMPANY:
                $results[Role::COMPANY] = self::getLocalizedDescription(Role::COMPANY);
                break;
            case Role::DEPARTMENT:
                $results[Role::DEPARTMENT] = self::getLocalizedDescription(Role::DEPARTMENT);
                break;
            case Role::MEMBER:
            case Role::MANAGER:
                $results[Role::MEMBER] = self::getLocalizedDescription(Role::MEMBER);
                $results[Role::MANAGER] = self::getLocalizedDescription(Role::MANAGER);
                break;
        }

        return $results;
    }
}
