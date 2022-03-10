<?php

namespace App\Http\UseCase\CompanyGroup;

use App\Enums\Role;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo = null)
    {
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
    }

    public function __invoke(): array
    {
        $user = Auth::user();

        if ($user->role === Role::ADMIN) {
            return [];
        }

        $companyGroupId = $user->company->company_group_id;
        $companies = $this->companyRepo->getByCompanyGroupId($companyGroupId);

        return [
            'companies' => $companies,
        ];
    }
}
