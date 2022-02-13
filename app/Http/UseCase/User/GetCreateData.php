<?php
namespace App\Http\UseCase\User;

use App\Enums\Role;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\DepartmentRepository;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetCreateData
{
    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    /** @var DepartmentRepositoryInterface */
    private $departmentRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo = null, DepartmentRepositoryInterface $departmentRepo = null)
    {
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
        $this->departmentRepo = $departmentRepo ?? new DepartmentRepository();
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $departments = $this->departmentRepo->getByCompanyId($companyId);
        $isMaster = (bool) $user->companies->is_master;
        $role = $user->role;
        $companies = $this->companyRepo->getByCompanyGroupId($user->companies->company_group_id);
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
