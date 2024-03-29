<?php

namespace App\Http\UseCase\Api\Like;

use App\Repositories\Interfaces\CommentLikeUserRepositoryInterface;
use App\Repositories\CommentLikeUserRepository;
use PhpParser\Node\Stmt\Return_;
use Flash;

class LikeOperation
{
    /** @var CommentLikeUserRepositoryInterface */
    private $CommentLikeUserRepo;


    public function __construct(
        CommentLikeUserRepositoryInterface $CommentLikeUserRepo = null
    ) {
        $this->CommentLikeUserRepo = $CommentLikeUserRepo ?? new CommentLikeUserRepository();
    }

    public function __invoke(array $input) :bool
    {
        $userId = $input['user_id'];
        $commentId = $input['comment_id'];

        //このログインユーザーがすでにいいねを過去にしていた場合、モデルが取得される。
        $commentLikeUser = $this->CommentLikeUserRepo->findByCommentIdAndUserId($commentId, $userId);
        if(is_null($commentLikeUser)) {
            //いいねがなかった場合、comment_like_usersテーブルへレコードを追加。
            $this->CommentLikeUserRepo->create([
                'comment_id' => $commentId,
                'user_id' => $userId,
                'is_like' => true,
            ]);

            return true;
        }

        //いいねしていた場合、対象レコードのis_likeをtrueへ
        $this->CommentLikeUserRepo->update($commentLikeUser->id, [
            'is_like' => true,
        ]);
        return true;
    }
}
