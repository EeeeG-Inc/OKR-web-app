<?php

namespace App\Repositories;

use App\Models\ObjectiveScoreHistory;
use App\Repositories\Interfaces\ObjectiveScoreHistoryRepositoryInterface;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;

class ObjectiveScoreHistoryRepository implements ObjectiveScoreHistoryRepositoryInterface
{
    /** @var ObjectiveScoreHistory */
    private $objectiveScoreHistory;

    public function __construct(ObjectiveScoreHistory $objectiveScoreHistory = null)
    {
        $this->objectiveScoreHistory = $objectiveScoreHistory ?? new ObjectiveScoreHistory;
    }

    /**
     * find
     *
     * @param integer $id
     * @return ObjectiveScoreHistory|null
     */
    public function find(int $id): ?ObjectiveScoreHistory
    {
        return $this->objectiveScoreHistory->findOrFail($id);
    }

    /**
     * create
     *
     * @param array $input
     * @return ObjectiveScoreHistory
     */
    public function create(array $input): ObjectiveScoreHistory
    {
        return $this->objectiveScoreHistory->create($input);
    }

    /**
     * update
     *
     * @param integer $id
     * @param array $input
     * @return boolean
     */
    public function update(int $id, array $input): bool
    {
        $model = $this->objectiveScoreHistory->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    /**
     * 本日のスコア履歴が存在するかどうか
     *
     * @param integer $objectiveId
     * @return boolean
     */
    public function isTodayScoreExists(int $objectiveId): bool
    {
        $today = CarbonImmutable::today();
        return $this->objectiveScoreHistory
            ->where('objective_id', $objectiveId)
            ->whereDate('created_at', $today)
            ->exists();
    }

    /**
     * objective_id から本日スコア履歴一件取得
     *
     * @param integer $objectiveId
     * @return ObjectiveScoreHistory|null
     */
    public function findByObjectiveId(int $objectiveId): ?ObjectiveScoreHistory
    {
        $today = CarbonImmutable::today();
        return $this->objectiveScoreHistory
            ->where('objective_id', $objectiveId)
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * objective_id から取得
     *
     * @param integer $objectiveId
     * @return Collection
     */
    public function getByObjectiveId(int $objectiveId): Collection
    {
        return $this->objectiveScoreHistory
            ->where('objective_id', $objectiveId)
            ->orderBy('created_at')
            ->get();
    }
}
