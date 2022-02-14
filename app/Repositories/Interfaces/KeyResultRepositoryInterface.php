<?php

namespace App\Repositories\Interfaces;

use App\Models\KeyResult;
use Illuminate\Database\Eloquent\Collection;

interface KeyResultRepositoryInterface
{
    public function find(int $id): ?KeyResult;

    public function create(array $input): KeyResult;

    public function update(int $id, array $input): bool;

    public function delete(KeyResult $target): bool;

    public function getByObjectiveId(int $objectiveId): Collection;
}
