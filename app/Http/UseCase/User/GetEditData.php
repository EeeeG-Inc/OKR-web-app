<?php
namespace App\Http\UseCase\User;

use App\Enums\Role;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    private $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo = null)
    {
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $role = $user->role;
        $companies = $this->companyRepo->getByCompanyGroupId($user->companies->company_group_id);
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
