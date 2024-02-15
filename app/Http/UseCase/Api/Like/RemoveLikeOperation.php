<?php

namespace App\Http\UseCase\Api\Like;

use App\Repositories\Interfaces\CommentLikeUserRepositoryInterface;
use App\Repositories\CommentLikeUserRepository;
use PhpParser\Node\Stmt\Return_;
use Flash;

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
        $userId = $input['user_id'];
        $commentId = $input['comment_id'];

        //対象コメントのモデルを取得
        $alreadyLike = $this->CommentLikeUserRepo->alreadyLike($commentId, $userId);

        //いいねの削除
        $this->CommentLikeUserRepo->likeCansel($alreadyLike);

        return true;
    }
}
