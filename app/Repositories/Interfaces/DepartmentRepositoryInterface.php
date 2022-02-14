<?php

namespace App\Repositories\Interfaces;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentRepositoryInterface
{
    public function find(int $id): ?Department;

    public function create(array $input): Department;

    public function update(int $id, array $input): bool;

    public function delete(Department $target): bool;

    public function getByCompanyId(int $companyId): Collection;
}
