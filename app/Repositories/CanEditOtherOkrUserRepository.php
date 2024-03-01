<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Models\CanEditOtherOkrUser;
use App\Repositories\Interfaces\CanEditOtherOkrUserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CanEditOtherOkrUserRepository implements CanEditOtherOkrUserRepositoryInterface
{
    /** @var CanEditOtherOkrUser */
    private $canEditOtherOkrUser;

    public function __construct(CanEditOtherOkrUser $canEditOtherOkrUser = null)
    {
        $this->canEditOtherOkrUser = $canEditOtherOkrUser ?? new CanEditOtherOkrUser;
    }

    public function find(int $id): ?CanEditOtherOkrUser
    {
        return $this->canEditOtherOkrUser->findOrFail($id);
    }

    public function create(array $input): CanEditOtherOkrUser
    {
        return $this->canEditOtherOkrUser->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->canEditOtherOkrUser->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function getByUserId(int $userId): Collection
    {
        return $this->canEditOtherOkrUser->where([
            ['user_id', '=', $userId],
        ])->get();
    }

    public function getTargetUserIdsByCanEdit(int $userId, bool $canEdit = true): array
    {
        $targetUserIds = $this->canEditOtherOkrUser->where([
            ['user_id', '=', $userId],
            ['can_edit', '=', $canEdit],
        ])->pluck('target_user_id')->toArray();

        if (!in_array($userId, $targetUserIds)) {
            // ログインユーザ自身も追加
            $targetUserIds[] = $userId;
        }

        sort($targetUserIds);
        return $targetUserIds;
    }

    public function isExists(int $userId, int $targetUserId): bool
    {
        return $this->canEditOtherOkrUser
            ->where('user_id', $userId)
            ->where('target_user_id', $targetUserId)
            ->exists();
    }

    public function findByUserIdAndTargetUserId(int $userId, int $targetUserId): ?CanEditOtherOkrUser
    {
        return $this->canEditOtherOkrUser
            ->where('user_id', $userId)
            ->where('target_user_id', $targetUserId)
            ->first();
    }
}
