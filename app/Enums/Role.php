<?php

namespace App\Enums;

use App\Models\Company;
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

    public static function getFontAwesome(int $role, Company $company = null): string
    {
        $result = '';
        switch ($role) {
            case self::COMPANY:
                if (is_null($company)) {
                    $result = '<i class="fa-solid fa-building fa-fw fa-lg"></i>';
                } else {
                    $result = self::getCompanyFontAwesome($company);
                }
                break;
            case self::DEPARTMENT:
                $result = '<i class="fa-solid fa-briefcase fa-fw fa-lg"></i>';
                break;
            case self::MANAGER:
                $result = '<i class="fa-solid fa-user-gear fa-fw fa-lg"></i>';
                break;
            case self::MEMBER:
                $result = '<i class="fa-solid fa-user fa-fw fa-lg"></i>';
                break;
        }
        return $result;
    }

    public static function getCompanyFontAwesome(Company $company): string
    {
        if ($company->is_master) {
            return '<i class="fa-solid fa-buildings fa-city fa-lg"></i>';
        }
        return '<i class="fa-solid fa-building fa-fw fa-lg"></i>';
    }
}
