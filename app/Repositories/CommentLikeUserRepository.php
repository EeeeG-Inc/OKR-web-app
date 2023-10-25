<?php

namespace App\Repositories;

use App\Models\CommentLikeUser;
use App\Repositories\Interfaces\CommentLikeUserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentLikeUserRepository implements CommentLikeUserRepositoryInterface
{
    /** @var CommentLikeUser */
    private $CommentLikeUser;

    public function __construct(CommentLikeUser $commentLikeUser = null)
    {
        $this->CommentLikeUser = $commentLikeUser ?? new CommentLikeUser;
    }

    public function find(int $id): ?CommentLikeUser
    {
        return $this->CommentLikeUser->findOrFail($id);
    }

    public function create(array $input): CommentLikeUser
    {
        return $this->CommentLikeUser->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->CommentLikeUser->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(CommentLikeUser $target): bool
    {
        return $target->delete();
    }

    //ログインユーザーがイイねをしているいかを判定するメソッド。
    public function isLikedBy($comment,int $id): bool {
        return CommentLikeUser::where('comment_id', $comment->id)->where('is_like', TRUE )->where('user_id', $id )->first() !==null;
    }

    //コメントのいいねの数をカウントするメソッド。
    public function likeCount($comment): int {
        return count(CommentLikeUser::where('comment_id', $comment->id)->where('is_like', TRUE )->get());
    }

}
