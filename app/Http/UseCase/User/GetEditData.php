<?php
namespace App\Http\UseCase\User;

use App\Enums\Role;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Services\User\CompanyService;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    /** @var CompanyService */
    private $companyService;

    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    public function __construct(CompanyService $companyService, CompanyRepositoryInterface $companyRepo = null)
    {
        $this->companyService = $companyService;
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $companies = $this->companyRepo->getByCompanyGroupId($user->companies->company_group_id);

        return [
            'user' => $user,
            'companyId' => $companyId,
            'roles' => Role::getRolesWhenUpdateUser($user->role),
            'companyNames' => $this->companyService->getCompanyNamesByRole($companies, $user->role, $companyId, $user),
        ];
    }
}
