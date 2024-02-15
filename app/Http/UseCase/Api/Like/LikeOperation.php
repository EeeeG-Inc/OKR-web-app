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

    public function __invoke(array $input)
    {
        $user_id = $input['user_id']; //操作者id
        $comment_id = $input['comment_id']; //コメントid

        try {
            //このログインユーザーがすでにいいねを過去にしていた場合、モデルが取得される。
            $alreadyLike = $this->CommentLikeUserRepo->alreadyLike($comment_id, $user_id);
            if($alreadyLike) {
                //いいねしていた場合、対象レコードのis_likeをtrueへ
                $this->CommentLikeUserRepo->update($alreadyLike);
            } else {
                //いいねがなかった場合、comment_like_usersテーブルへレコードを追加。
                $this->CommentLikeUserRepo->create([
                    'comment_id' => $comment_id,
                    'user_id' => $user_id,
                    'is_like' => true,
                ]);
            }
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        return true;
    }
}
