<?php
namespace App\Http\UseCase\User;

use App\Enums\Role;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\DepartmentRepository;
use App\Services\User\CompanyService;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetCreateData
{
    /** @var CompanyService */
    private $companyService;

    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    /** @var DepartmentRepositoryInterface */
    private $departmentRepo;

    public function __construct(
        CompanyService $companyService,
        CompanyRepositoryInterface $companyRepo = null,
        DepartmentRepositoryInterface $departmentRepo = null
    ) {
        $this->companyService = $companyService;
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
        $this->departmentRepo = $departmentRepo ?? new DepartmentRepository();
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $departments = $this->departmentRepo->getByCompanyId($companyId);
        $isMaster = (bool) $user->company->is_master;
        $companies = $this->companyRepo->getByCompanyGroupId($user->company->company_group_id);

        // 自身の会社の部署データが存在しない場合、まず部署アカウントのみ作成させる
        if ($departments->isEmpty()) {
            Flash::error(__('validation.not_found_department'));
            $roles = Role::getRolesWhenCreateUserIfNoDepartment($user->role, $isMaster);
        } else {
            $roles = Role::getRolesWhenCreateUser($user->role, (bool) $isMaster);
        }

        return [
            'user' => $user,
            'companyId' => $companyId,
            'roles' => $roles,
            'companyNames' => $this->companyService->getCompanyNamesByIsMaster($companies, $isMaster, $companyId, $user),
        ];
    }
}
