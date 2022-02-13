<?php

namespace App\Repositories\Interfaces;

use App\Models\Quarter;
use Illuminate\Database\Eloquent\Collection;

interface QuarterRepositoryInterface
{
    public function find(int $id): ?Quarter;

    public function create(array $input): Quarter;

    public function update(int $id, array $input): bool;

    public function getByCompanyId(int $companyId): Collection;

    public function findByQuarterAndCompanyId(int $quarter, int $companyId): ?Quarter;
}
