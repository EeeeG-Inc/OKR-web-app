<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LikeRequest;
use App\Http\UseCase\Api\Like\LikeOperation;
use App\Http\UseCase\Api\Like\RemoveLikeOperation;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    /**
     *  @OA\Post(
     *      path="/api/like",
     *      tags={"いいね追加"},
     *      description="コメントにいいねを追加する",
     *      @OA\Response(
     *          response="200",
     *          description="いいね追加成功",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="comment_id",
     *                  description="コメントID",
     *                  type="int"
     *              ),
     *              @OA\Property(
     *                  property="user_id",
     *                  description="ユーザーID",
     *                  type="int"
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function like(LikeRequest $request, LikeOperation $case):JsonResponse
    {
        $input = $request->validated();
        $result = $case($input);

        return new JsonResponse([
            'result' => $result,
        ], Response::HTTP_OK);
    }

    /**
     *  @OA\Post(
     *      path="/api/remove",
     *      tags={"いいね取り消し"},
     *      description="コメントのいいねを取り消す",
     *      @OA\Response(
     *          response="200",
     *          description="いいね取り消し成功",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="comment_id",
     *                  description="コメントID",
     *                  type="int"
     *              ),
     *              @OA\Property(
     *                  property="user_id",
     *                  description="ユーザーID",
     *                  type="int"
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function remove(LikeRequest $request, RemoveLikeOperation $case):JsonResponse
    {
        $input = $request->validated();
        $result = $case($input);

        return new JsonResponse([
            'result' => $result,
        ], Response::HTTP_OK);
    }
}
