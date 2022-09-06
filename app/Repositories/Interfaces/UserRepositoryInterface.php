<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function find(int $id): ?User;

    public function create(array $input): User;

    public function update(int $id, array $input): bool;

    public function delete(User $target): bool;

    public function getByCompanyId(int $companyId): Collection;

    public function getCompanyUserByCompanyIdAndName(int $companyId, string $name): Collection;

    public function getDepartmentUserByCompanyIdAndName(int $departmentId, string $name): Collection;

    public function paginate(int $pagenateNum): LengthAwarePaginator;

    public function paginateByCompanyId(int $pagenateNum, int $companyId): LengthAwarePaginator;

    public function paginateByCompanyIds(int $pagenateNum, array $companyIds): LengthAwarePaginator;
}
