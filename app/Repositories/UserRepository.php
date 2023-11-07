<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /** @var User */
    private $user;

    public function __construct(User $user = null)
    {
        $this->user = $user ?? new User;
    }

    public function find(int $id): ?User
    {
        return $this->user->findOrFail($id);
    }

    public function create(array $input): User
    {
        return $this->user->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->user->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(User $target): bool
    {
        return $target->delete();
    }

    public function getByCompanyId(int $companyId): Collection
    {
        return $this->user->where([
            ['company_id', '=', $companyId],
        ])->get();
    }

    public function getCompanyUserByCompanyIdAndName(int $companyId, string $name): Collection
    {
        return $this->user->where([
            ['company_id', '=', $companyId],
            ['name', '=', $name],
            ['role', '=', Role::COMPANY],
        ])->get();
    }

    public function getDepartmentUserByCompanyIdAndName(int $departmentId, string $name): Collection
    {
        return $this->user->where([
            ['department_id', '=', $departmentId],
            ['name', '=', $name],
            ['role', '=', Role::DEPARTMENT],
        ])->get();
    }

    public function getWhereNotInUserIds(array $userIds, int $companyId): Collection
    {
        return $this->user
            ->whereNotIn('id', $userIds)
            ->where([
                ['company_id', '=', $companyId],
            ])
            ->get();
    }

    public function paginate(int $pagenateNum): LengthAwarePaginator
    {
        return $this->getBuilderNotWhereRoleAdmin()
            ->orderBy('role')
            ->paginate($pagenateNum);
    }

    public function paginateByCompanyId(int $pagenateNum, int $companyId): LengthAwarePaginator
    {
        return $this->getBuilderNotWhereRoleAdmin()
            ->where('company_id', $companyId)
            ->orderBy('role')
            ->paginate($pagenateNum);
    }

    public function paginateByCompanyIds(int $pagenateNum, array $companyIds): LengthAwarePaginator
    {
        return $this->getBuilderNotWhereRoleAdmin()
            ->whereIn('company_id', $companyIds)
            ->orderBy('role')
            ->paginate($pagenateNum);
    }

    private function getBuilderNotWhereRoleAdmin(): Builder
    {
        return $this->user->where('role', '!=', Role::ADMIN);
    }
}
