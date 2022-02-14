<?php

namespace App\Repositories\Interfaces;

use App\Models\CompanyGroup;
use Illuminate\Database\Eloquent\Collection;

interface CompanyGroupRepositoryInterface
{
    public function find(int $id): ?CompanyGroup;

    public function create(array $input): CompanyGroup;

    public function update(int $id, array $input): bool;

    public function delete(CompanyGroup $target): bool;
}
