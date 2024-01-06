<?php

namespace App\Http\UseCase\Api\Like;

use App\Repositories\Interfaces\CommentLikeUserRepositoryInterface;
use App\Repositories\CommentLikeUserRepository;
use PhpParser\Node\Stmt\Return_;

class LikeOperation
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
        $user_id = $input['user_id']; //操作者idの取得
        $comment_id = $input['comment_id']; //コメントidの取得



        //このログインユーザーがすでにいいねを過去にしていたかチェック
        $alreadyLike = $this->CommentLikeUserRepo->alreadyLike($comment_id,$user_id);
        logger($user_id);
        logger($comment_id);
        logger($alreadyLike);


        //いいねしていた場合、対象レコードのis_likeをtrueへ

        //いいねがなかった場合、comment_like_usersテーブルへレコードを追加。

        return;
    }
}
