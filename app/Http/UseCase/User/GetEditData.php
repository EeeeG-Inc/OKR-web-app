<?php
namespace App\Http\UseCase\User;

use App\Enums\Role;
use App\Models\Company;
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
        $role = $user->role;
        $companies = Company::where('company_group_id', '=', $user->companies->company_group_id)->get();
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

        $roles = Role::getRolesWhenUpdateUser($role);

        return [
            'user' => $user,
            'companyId' => $companyId,
            'roles' => $roles,
            'companyNames' => $companyNames,
        ];
    }
}
