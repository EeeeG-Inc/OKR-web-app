<?php

namespace App\Repositories\Interfaces;

use App\Models\Slack;
use Illuminate\Database\Eloquent\Collection;

interface SlackRepositoryInterface
{
    public function find(int $id): ?Slack;

    public function create(array $input): Slack;

    public function update(int $id, array $input): bool;

    public function delete(Slack $target): bool;

    public function findByCompanyId(int $companyId): ?Slack;
}
