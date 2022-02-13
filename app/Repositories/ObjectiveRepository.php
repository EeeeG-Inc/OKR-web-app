<?php

namespace App\Repositories;

use App\Models\Objective;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ObjectiveRepository implements ObjectiveRepositoryInterface
{
    /** @var Objective */
    public $objective;

    public function __construct(Objective $objective = null)
    {
        $this->objective = $objective ?? new Objective;
    }

    public function find(int $id): ?Objective
    {
        return $this->objective->findOrFail($id);
    }

    public function create(array $input): Objective
    {
        return $this->objective->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->objective->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(Objective $target): bool
    {
        return $target->delete();
    }

    public function getByUserId(int $userId): Collection
    {
        return Objective::where('user_id', $userId)->get();
    }

    public function getYearByUserId(int $userId): Collection
    {
        return $this->objective->where('user_id', $userId)
            ->distinct()
            ->orderBy('year', 'desc')
            ->select('year')
            ->get();
    }
}
