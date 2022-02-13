<?php

namespace App\Repositories;

use App\Models\KeyResult;
use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class KeyResultRepository implements KeyResultRepositoryInterface
{
    /** @var KeyResult */
    public $keyResult;

    public function __construct(KeyResult $keyResult = null)
    {
        $this->keyResult = $keyResult ?? new KeyResult;
    }

    public function find(int $id): ?KeyResult
    {
        return $this->keyResult->findOrFail($id);
    }

    public function create(array $input): KeyResult
    {
        return $this->keyResult->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->keyResult->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(KeyResult $target): bool
    {
        return $target->delete();
    }

    public function getByObjectiveId(int $objectiveId): Collection
    {
        return $this->keyResult->where('objective_id', $objectiveId)->get();
    }
}
