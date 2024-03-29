<?php

namespace App\Repositories\Interfaces;

use App\Models\CommentLikeUser;
use Illuminate\Database\Eloquent\Collection;

interface CommentLikeUserRepositoryInterface
{
    public function find(int $id): ?CommentLikeUser;

    public function create(array $input): CommentLikeUser;

    public function update(int $id, array $input): bool;

    public function delete(CommentLikeUser $target): bool;

    public function isLikedBy(int $comment_id, int $id): bool;

    public function likeCount(int $comment_id): int;

    public function findByCommentIdAndUserId(int $comment_id, int $user_id): ?CommentLikeUser;

}
