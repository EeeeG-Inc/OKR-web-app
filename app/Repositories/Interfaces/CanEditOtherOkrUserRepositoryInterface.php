<?php

namespace App\Repositories\Interfaces;

use App\Models\CanEditOtherOkrUser;
use Illuminate\Database\Eloquent\Collection;

interface CanEditOtherOkrUserRepositoryInterface
{
    public function find(int $id): ?CanEditOtherOkrUser;

    public function create(array $input): CanEditOtherOkrUser;

    public function update(int $id, array $input): bool;

    public function getByUserId(int $userId): Collection;

    public function getTargetUserIdsByCanEdit(int $userId, bool $canEdit = true): array;

    public function isExists(int $userId, int $targetUserId): bool;

    public function findByUserIdAndTargetUserId(int $userId, int $targetUserId): ?CanEditOtherOkrUser;
}
