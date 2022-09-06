<?php

namespace App\Repositories;

use App\Models\ApiToken;
use App\Repositories\Interfaces\ApiTokenRepositoryInterface;

class ApiTokenRepository implements ApiTokenRepositoryInterface
{
    /** @var ApiToken */
    private $apiToken;

    public function __construct(ApiToken $apiToken = null)
    {
        $this->apiToken = $apiToken ?? new ApiToken;
    }

    public function find(int $id): ?ApiToken
    {
        return $this->apiToken->findOrFail($id);
    }

    public function create(array $input): ApiToken
    {
        return $this->apiToken->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->apiToken->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(ApiToken $target): bool
    {
        return $target->delete();
    }

    public function findByCompanyId(int $companyId): ?ApiToken
    {
        return ApiToken::where('company_id', $companyId)->first();
    }
}
