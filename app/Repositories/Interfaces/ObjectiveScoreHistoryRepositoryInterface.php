<?php

namespace App\Repositories\Interfaces;

use App\Models\ObjectiveScoreHistory;
use Illuminate\Database\Eloquent\Collection;

interface ObjectiveScoreHistoryRepositoryInterface
{
    public function find(int $id): ?ObjectiveScoreHistory;

    public function create(array $input): ObjectiveScoreHistory;

    public function update(int $id, array $input): bool;

    public function isTodayScoreExists(int $objectiveId): bool;

    public function findByObjectiveId(int $objectiveId): ?ObjectiveScoreHistory;

    public function getByObjectiveId(int $objectiveId): Collection;
}
