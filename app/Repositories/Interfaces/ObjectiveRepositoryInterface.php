<?php

namespace App\Repositories\Interfaces;

use App\Models\Objective;
use Illuminate\Database\Eloquent\Collection;

interface ObjectiveRepositoryInterface
{
    public function find(int $id): ?Objective;

    public function create(array $input): Objective;

    public function getByUserId(int $userId): Collection;

    public function update(int $id, array $input): bool;

    public function delete(Objective $target): bool;

    public function getYearByUserId(int $userId): Collection;
}
