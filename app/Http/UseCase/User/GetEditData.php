<?php
namespace App\Http\UseCase\User;

use App\Enums\Role;
use App\Models\Company;
use App\Models\Department;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    public function __construct()
    {
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $isMaster = (bool) $user->companies->is_master;
        $role = $user->role;
        $companies = Company::where('company_group_id', '=', $user->companies->company_group_id)->get();
        $companyNames = [];

        // 関連会社のアカウントも編集可能
        if ($isMaster) {
            foreach ($companies as $company) {
                $companyNames[$company->id] = $company->name;
            }
        // 自身の会社アカウントのみ編集可能
        } else {
            $companyNames[$companyId] = $user->companies->name;
        }

        $roles = Role::getRolesInWhenUpdateUser($role);

        return [
            'user' => $user,
            'companyId' => $companyId,
            'roles' => $roles,
            'companyNames' => $companyNames,
        ];
    }
}
