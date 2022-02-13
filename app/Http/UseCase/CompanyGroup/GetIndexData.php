<?php

namespace App\Http\UseCase\CompanyGroup;

use App\Enums\Role;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    private $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo = null)
    {
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
    }

    public function __invoke(): array
    {
        if (Auth::user()->role === Role::ADMIN) {
            return [];
        }

        $companyGroupId = Auth::user()->companies()->first()->company_group_id;
        $companies = $this->companyRepo->getByCompanyGroupId($companyGroupId);

        return [
            'companies' => $companies,
        ];
    }
}
