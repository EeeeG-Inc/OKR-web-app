<?php

namespace App\Repositories;

use App\Models\Slack;
use App\Repositories\Interfaces\SlackRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SlackRepository implements SlackRepositoryInterface
{
    /** @var Slack */
    public $slack;

    public function __construct(Slack $slack = null)
    {
        $this->slack = $slack ?? new Slack;
    }

    public function find(int $id): ?Slack
    {
        return $this->slack->findOrFail($id);
    }

    public function create(array $input): Slack
    {
        return $this->slack->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->slack->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(Slack $target): bool
    {
        return $target->delete();
    }

    public function findByCompanyId(int $companyId): ?Slack
    {
        return Slack::where('company_id', $companyId)->first();
    }
}
