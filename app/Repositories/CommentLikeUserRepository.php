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
    public function isLikedBy(int $comment_id, int $id): bool
    {
        return CommentLikeUser::where('comment_id', $comment_id)->where('is_like', true)->where('user_id', $id)->first() !==null;
    }

    //コメントのいいねの数をカウントするメソッド。
    public function likeCount(int $comment_id): int
    {
        return CommentLikeUser::where('comment_id', $comment_id)->where('is_like', true)->get()->count();
    }

    //ログインユーザーによるいいねのレコードが存在している場合、モデルを返すメソッド。
    public function alreadyLike(int $comment_id, int $user_id): ?CommentLikeUser
    {
        $like = CommentLikeUser::where('comment_id', $comment_id)
            ->where('user_id', $user_id)
            ->get();
        return $like->isNotEmpty() ? $like->first() : null;
    }

    //いいねを取り消すメソッド。
    public function likeCansel(CommentLikeUser $target): bool
    {
        return $target->update([
            'is_like' => false
        ]);
    }
}
