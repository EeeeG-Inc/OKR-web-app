<?php
namespace App\Http\UseCase\User;

use App\Enums\Role;
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
        $departments = Department::where('company_id', $user->company_id)->get();
        $departmentNames = [];
        $isMaster = (bool) $user->companies->is_master;
        $role = $user->role;

        if ($departments->isEmpty()) {
            Flash::error(__('validation.not_found_department'));
            $roles = Role::getRolesInWhenCreateUserIfNoDepartment($role, $isMaster);
        } else {
            foreach ($departments as $department) {
                $departmentNames[$department->id] = $department->name;
            }
            $roles = Role::getRolesInWhenCreateUser($role, (bool) $isMaster);
        }

        $companyCreatePermission = false;

        if ($role === Role::ADMIN || (($role === Role::COMPANY) && ($isMaster === true))) {
            $companyCreatePermission = true;
        }

        return [
            'user' => $user,
            'roles' => $role,
            'departmentNames' => $departmentNames,
            'companyCreatePermission' => $companyCreatePermission,
        ];
    }
}
