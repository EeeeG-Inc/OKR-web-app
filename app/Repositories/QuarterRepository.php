<?php

namespace App\Repositories;

use App\Models\Quarter;
use App\Repositories\Interfaces\QuarterRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class QuarterRepository implements QuarterRepositoryInterface
{
    /** @var Quarter */
    private $quarter;

    public function __construct(Quarter $quarter = null)
    {
        $this->quarter = $quarter ?? new Quarter;
    }

    public function find(int $id): ?Quarter
    {
        return $this->quarter->findOrFail($id);
    }

    public function create(array $input): Quarter
    {
        return $this->quarter->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->quarter->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function getByCompanyId(int $companyId): Collection
    {
        return $this->quarter->where('company_id', $companyId)->orderBy('quarter', 'asc')->get();
    }

    public function findByQuarterAndCompanyId(int $quarter, int $companyId): ?Quarter
    {
        return $this->quarter->where([
            ['company_id', '=', $companyId],
            ['quarter', '=', $quarter],
        ])->first();
    }
}
