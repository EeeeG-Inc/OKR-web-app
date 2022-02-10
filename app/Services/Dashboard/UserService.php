<?php

namespace App\Services\Dashboard;

use App\Enums\Role;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    /** @var int */
    private $pagenateNum;

    public function __construct()
    {
        $this->pagenateNum = 15;
    }

    public function getUsersForAdmin(array $input): LengthAwarePaginator
    {
        if (is_null($input['company_ids'] ?? null)) {
            // すべてのアカウントを取得する
            return User::where('role', '!=', Role::ADMIN)->paginate($this->pagenateNum);
        }
        return $this->getRequestedUsers($input);
    }

    public function getUsers(User $user, array $input): LengthAwarePaginator
    {
        if (is_null($input['company_ids'] ?? null)) {
            // 自身が所属する会社アカウントのみ取得する
            return User::where('role', '!=', Role::ADMIN)
                ->where('company_id', $user->company_id)
                ->paginate($this->pagenateNum);
        }
        return $this->getRequestedUsers($input);
    }

    public function getCompanyIdsChecksForAdmin(array $input, array $companies): array
    {
        $companyIdsChecks = [];

        if (is_null($input['company_ids'] ?? null)) {
            // すべての会社にチェック
            foreach ($companies as $company) {
                $companyIdsChecks[$company['id']] = true;
            }
            return $companyIdsChecks;
        }
        return $this->getRequestedCompanyIdsChecks($input, $companies);
    }

    public function getCompanyIdsChecks(array $input, array $companies): array
    {
        $companyIdsChecks = [];

        if (is_null($input['company_ids'] ?? null)) {
            // 自身が所属する会社アカウントのみチェック
            foreach ($companies as $company) {
                if ($company['id'] === Auth::user()->company_id) {
                    $companyIdsChecks[$company['id']] = true;
                } else {
                    $companyIdsChecks[$company['id']] = false;
                }
            }
            return $companyIdsChecks;
        }
        return $this->getRequestedCompanyIdsChecks($input, $companies);
    }

    private function getRequestedUsers(array $input): LengthAwarePaginator
    {
        $companyIds = [];

        foreach ($input['company_ids'] as $k => $v) {
            $companyIds[$k] = ['id' => $v];
        }

        // リクエストされた会社に所属するアカウントを取得する
        return User::where('role', '!=', Role::ADMIN)
            ->whereIn('company_id', $companyIds)
            ->paginate($this->pagenateNum);
    }

    private function getRequestedCompanyIdsChecks(array $input, array $companies): array
    {
        $companyIdsChecks = [];

        foreach ($companies as $company) {
            if (in_array($company['id'], $input['company_ids'])) {
                $companyIdsChecks[$company['id']] = true;
            } else {
                $companyIdsChecks[$company['id']] = false;
            }
        }
        return $companyIdsChecks;
    }
}
