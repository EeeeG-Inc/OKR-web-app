<?php

namespace App\Repositories;

use App\Enums\Quarter;
use App\Models\Objective;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class ObjectiveRepository implements ObjectiveRepositoryInterface
{
    /** @var Objective */
    private $objective;

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
        return $this->objective->where('user_id', $userId)->get();
    }

    public function getByUserIdAndYearAndQuarterId(int $userId, int $year, int $quarterId, bool $isArchived = false, bool $isIncludeFullYear = false): Collection
    {
        $where = [
            ['user_id', '=', $userId],
            ['year', '=', $year],
            ['is_archived', '=', $isArchived]
        ];

        $whereIn = [$quarterId];

        // 通年を含めるかどうか
        if (($quarterId !== Quarter::FULL_YEAR_ID) && $isIncludeFullYear) {
            $whereIn[] = Quarter::FULL_YEAR_ID;
        }

        return Objective::where($where)->whereIn('quarter_id', $whereIn)->get();
    }

    public function getYearByUserId(int $userId): Collection
    {
        return $this->objective->where('user_id', $userId)
            ->distinct()
            ->orderBy('year', 'desc')
            ->select('year')
            ->get();
    }

    public function getYearByCompanyId(int $companyId): SupportCollection
    {
        return $this->objective
            ->leftJoin('users', 'users.id', '=', 'objectives.user_id')
            ->where('users.company_id', $companyId)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
    }

    public function getQuarterIdsByCompanyId(int $companyId): SupportCollection
    {
        return $this->objective
            ->leftJoin('users', 'users.id', '=', 'objectives.user_id')
            ->where('users.company_id', $companyId)
            ->distinct()
            ->orderBy('quarter_id')
            ->pluck('quarter_id');
    }

}
