<?php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{
    public Company $company;

    public function __construct(Company $company = null)
    {
        $this->company = $company ?? new Company;
    }

    public function find(int $id): ?Company
    {
        return $this->company->findOrFail($id);
    }

    public function get(): Collection
    {
        return $this->company->get();
    }

    public function create(array $input): Company
    {
        return $this->company->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->company->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function getByCompanyGroupId(int $companyGroupId): Collection
    {
        return $this->company::where('company_group_id', $companyGroupId)->get();
    }
}
