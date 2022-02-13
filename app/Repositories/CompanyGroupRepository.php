<?php

namespace App\Repositories;

use App\Models\CompanyGroup;
use App\Repositories\Interfaces\CompanyGroupRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompanyGroupRepository implements CompanyGroupRepositoryInterface
{
    /** @var CompanyGroup */
    public $companyGroup;

    public function __construct(CompanyGroup $companyGroup = null)
    {
        $this->companyGroup = $companyGroup ?? new CompanyGroup;
    }

    public function find(int $id): ?CompanyGroup
    {
        return $this->companyGroup->findOrFail($id);
    }

    public function create(array $input): CompanyGroup
    {
        return $this->companyGroup->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->companyGroup->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(CompanyGroup $target): bool
    {
        return $target->delete();
    }
}
