<?php

namespace App\Repositories\Interfaces;

use App\Models\ApiToken;

interface ApiTokenRepositoryInterface
{
    public function find(int $id): ?ApiToken;

    public function create(array $input): ApiToken;

    public function update(int $id, array $input): bool;

    public function delete(ApiToken $target): bool;

    public function findByCompanyId(int $companyId): ?ApiToken;
}
