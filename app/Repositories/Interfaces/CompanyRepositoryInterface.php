<?php

namespace App\Repositories\Interfaces;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    public function find(int $id): ?Company;

    public function get(): Collection;

    public function create(array $input): Company;

    public function update(int $id, array $input): bool;

    public function getByCompanyGroupId(int $companyGroupId): Collection;
}
