<?php

namespace App\Http\UseCase\Api\Like;

use App\Repositories\Interfaces\CommentLikeUserRepositoryInterface;
use App\Repositories\CommentLikeUserRepository;
use PhpParser\Node\Stmt\Return_;

class RemoveLikeOperation
{
    /** @var CommentLikeUserRepositoryInterface */
    private $CommentLikeUserRepo;


    public function __construct(
        CommentLikeUserRepositoryInterface $CommentLikeUserRepo = null
    ) {
        $this->CommentLikeUserRepo = $CommentLikeUserRepo ?? new CommentLikeUserRepository();
    }

    public function __invoke(array $input)
    {
        $user_id = $input['user_id']; //操作者id
        $comment_id = $input['comment_id']; //コメントid

        //対象コメントのモデルを取得
        $alreadyLike = $this->CommentLikeUserRepo->alreadyLike($comment_id,$user_id);

        //いいねの削除
        $this->CommentLikeUserRepo->likeCansel($alreadyLike);

        return;
    }
}
