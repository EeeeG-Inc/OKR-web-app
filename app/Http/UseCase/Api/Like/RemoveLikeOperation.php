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

    public function __invoke(array $input):bool
    {
        $userId = $input['user_id'];
        $commentId = $input['comment_id'];

        //対象コメントのモデルを取得
        $findByCommentIdAndUserId = $this->CommentLikeUserRepo->findByCommentIdAndUserId($commentId, $userId);

        //いいねの削除
        $this->CommentLikeUserRepo->update($findByCommentIdAndUserId->id, [
            'is_like' => false,
        ]);

        return true;
    }
}
