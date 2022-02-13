<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    /** @var Department */
    public $department;

    public function __construct(Department $department = null)
    {
        $this->department = $department ?? new Department;
    }

    public function find(int $id): ?Department
    {
        return $this->department->findOrFail($id);
    }

    public function create(array $input): Department
    {
        return $this->department->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->department->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(Department $target): bool
    {
        return $target->delete();
    }

    public function getByCompanyId(int $companyId): Collection
    {
        return $this->department->where('company_id', $companyId)->get();
    }
}
