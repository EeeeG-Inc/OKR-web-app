<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    public function find(int $id): ?Comment;

    public function create(array $input): Comment;

    public function update(int $id, array $input): bool;

    public function delete(Comment $target): bool;

    public function getByObjectiveId(int $objectiveId): Collection;
}
