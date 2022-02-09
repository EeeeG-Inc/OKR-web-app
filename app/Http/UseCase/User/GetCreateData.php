<?php
namespace App\Http\UseCase\User;

use App\Enums\Role;
use App\Models\Company;
use App\Models\Department;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetCreateData
{
    public function __construct()
    {
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $departments = Department::where('company_id', $companyId)->get();
        $isMaster = (bool) $user->companies->is_master;
        $role = $user->role;
        $companies = Company::where('company_group_id', '=', $user->companies->company_group_id)->get();
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

        // 自身の会社の部署データが存在しない場合、まず部署アカウントのみ作成させる
        if ($departments->isEmpty()) {
            Flash::error(__('validation.not_found_department'));
            $roles = Role::getRolesWhenCreateUserIfNoDepartment($role, $isMaster);
        } else {
            $roles = Role::getRolesWhenCreateUser($role, (bool) $isMaster);
        }

        return [
            'user' => $user,
            'companyId' => $companyId,
            'roles' => $roles,
            'companyNames' => $companyNames,
        ];
    }
}
