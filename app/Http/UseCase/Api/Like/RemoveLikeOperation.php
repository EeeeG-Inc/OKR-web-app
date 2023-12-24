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

        //dd('いいねとりけし');
        return;



        //logger($input);
        //$user_id = $user->id;
        // logger($user_id);


        //$comment_id = $input['comment_id']; //2.投稿idの取得






        // $already_liked = Like::where('user_id', $user_id)->where('review_id', $review_id)->first(); //3.

        // if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
        //     $like = new Like; //4.Likeクラスのインスタンスを作成
        //     $like->review_id = $review_id; //Likeインスタンスにreview_id,user_idをセット
        //     $like->user_id = $user_id;
        //     $like->save();
        // } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
        //     Like::where('review_id', $review_id)->where('user_id', $user_id)->delete();
        // }
        // //5.この投稿の最新の総いいね数を取得
        // $review_likes_count = Review::withCount('likes')->findOrFail($review_id)->likes_count;
        // $param = [
        //     'review_likes_count' => $review_likes_count,
        // ];
        // return response()->json($param); //6.JSONデータをjQueryに返す
    }
}
