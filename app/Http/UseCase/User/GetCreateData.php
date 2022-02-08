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
        $companyNames = [];
        $isMaster = (bool) $user->companies->is_master;
        $role = $user->role;
        $companies = Company::where('company_group_id', '=', $user->companies->company_group_id)->get();

        foreach ($companies as $company) {
            $companyNames[$company->id] = $company->name;
        }

        if ($departments->isEmpty()) {
            Flash::error(__('validation.not_found_department'));
            $roles = Role::getRolesInWhenCreateUserIfNoDepartment($role, $isMaster);
        } else {
            $roles = Role::getRolesInWhenCreateUser($role, (bool) $isMaster);
        }

        $companyCreatePermission = false;

        if ($role === Role::ADMIN || (($role === Role::COMPANY) && ($isMaster === true))) {
            $companyCreatePermission = true;
        }

        return [
            'user' => $user,
            'companyId' => $companyId,
            'roles' => $roles,
            'companyNames' => $companyNames,
            'companyCreatePermission' => $companyCreatePermission,
        ];
    }
}
