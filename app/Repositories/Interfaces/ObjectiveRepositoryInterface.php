<?php

namespace App\Repositories\Interfaces;

use App\Models\Objective;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

interface ObjectiveRepositoryInterface
{
    public function find(int $id): ?Objective;

    public function create(array $input): Objective;

    public function getByUserId(int $userId): Collection;

    public function getByUserIdAndYearAndQuarterId(int $userId, int $year, int $quarterId, bool $isArchived = false, bool $isIncludeFullYear = false): Collection;

    public function update(int $id, array $input): bool;

    public function delete(Objective $target): bool;

    public function getYearByUserId(int $userId): Collection;

    public function getYearByCompanyId(int $companyId): SupportCollection;

    public function getQuarterIdsByCompanyId(int $companyId): SupportCollection;
}
