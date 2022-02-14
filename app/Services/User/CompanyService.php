<?php

namespace App\Services\User;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CompanyService
{
    public function getCompanyNamesByRole(Collection $companies, int $role, int $companyId, User $user): array
    {
        $companyNames = [];

        foreach ($companies as $company) {
            switch ($role) {
                // 関連会社のアカウントとして移籍可能にする
                case Role::MEMBER:
                case Role::MANAGER:
                    $companyNames[$company->id] = $company->name;
                    break;
                // 会社・部署アカウントは所属する会社を変更できない
                default:
                    $companyNames[$companyId] = $user->companies->name;
            }
        }
        return $companyNames;
    }

    public function getCompanyNamesByIsMaster(Collection $companies, bool $isMaster, int $companyId, User $user): array
    {
        $companyNames = [];

        // 関連会社に紐付いたアカウントも作成可能
        if ($isMaster) {
            foreach ($companies as $company) {
                $companyNames[$company->id] = $company->name;
            }
        // 自身の会社に紐付いたアカウントのみ作成可能
        } else {
            $companyNames[$companyId] = $user->companies->name;
        }

        return $companyNames;
    }
}
