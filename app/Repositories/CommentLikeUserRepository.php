<?php

namespace App\Repositories;

use App\Models\CommentLikeUser;
use App\Repositories\Interfaces\CommentLikeUserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentLikeUserRepository implements CommentLikeUserRepositoryInterface
{
    /** @var CommentLikeUser */
    private $commentLikeUser;

    public function __construct(CommentLikeUser $commentLikeUser = null)
    {
        $this->commentLikeUser = $commentLikeUser ?? new CommentLikeUser;
    }

    public function find(int $id): ?CommentLikeUser
    {
        return $this->commentLikeUser->findOrFail($id);
    }

    public function create(array $input): CommentLikeUser
    {
        return $this->commentLikeUser->create($input);
    }

    public function update(CommentLikeUser $target): bool
    {
        return $target->update([
            'is_like' => true
        ]);
    }

    public function delete(CommentLikeUser $target): bool
    {
        return $target->delete();
    }

    //ログインユーザーがイイねをしているいかを判定するメソッド。
    public function isLikedBy(int $commentId, int $id): bool
    {
        return $this->commentLikeUser::where([
            ['comment_id', $commentId],
            ['is_like', true],
            ['user_id', $id]
        ])
        ->exists();
    }

    //コメントのいいねの数をカウントするメソッド。
    public function likeCount(int $commentId): int
    {
        return $this->commentLikeUser::where([
            ['comment_id', $commentId],
            ['is_like', true]
        ])
        ->count();
    }

    //ログインユーザーによるいいねのレコードが存在している場合、モデルを返すメソッド。
    public function alreadyLike(int $commentId, int $userId): ?CommentLikeUser
    {
        return $this->commentLikeUser::where([
            ['comment_id', $commentId],
            ['user_id', $userId]
        ])
        ->first();
    }

    //いいねを取り消すメソッド。
    public function likeCansel(CommentLikeUser $target): bool
    {
        return $target->update([
            'is_like' => false
        ]);
    }
}
