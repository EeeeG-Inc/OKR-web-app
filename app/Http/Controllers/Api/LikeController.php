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
    * @OA\Post(
    *      path="/api/like",
    *      tags={"いいね追加"},
    *      description="コメントにいいねを追加する",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\MediaType(
    *              mediaType="application/json",
    *              @OA\Schema(
    *                  type="object",
    *                   @OA\Property(
    *                       property="comment_id",
    *                       description="コメントID",
    *                       type="integer"
    *                   ),
    *                   @OA\Property(
    *                       property="user_id",
    *                       description="ユーザーID",
    *                       type="integer"
    *                   ),
    *              )
    *          )
    *      ),
    *      @OA\Response(
    *          response="200",
    *          description="いいね追加のDB更新",
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(
    *                  property="result",
    *                  description="結果",
    *                  type="boolean"
    *              ),
    *          ),
    *      ),
    *      @OA\Response(
    *          response="500",
    *          description="Internal Server Error",
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(
    *                  property="error",
    *                  type="string",
    *                  example="Internal Server Error"
    *              ),
    *          ),
    *      ),
    * )
    */
    public function like(LikeRequest $request, LikeOperation $case):JsonResponse
    {
        $input = $request->validated();
        $result = $case($input);

        if ($result === false) {
            return new JsonResponse([
                'error' => 'Internal Server Error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            'result' => $result,
        ], Response::HTTP_OK);
    }

    /**
    * @OA\Post(
    *      path="/api/like_remove",
    *      tags={"いいね取り消し"},
    *      description="コメントのいいねを取り消す",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\MediaType(
    *              mediaType="application/json",
    *              @OA\Schema(
    *                  type="object",
    *                   @OA\Property(
    *                       property="comment_id",
    *                       description="コメントID",
    *                       type="integer"
    *                   ),
    *                   @OA\Property(
    *                       property="user_id",
    *                       description="ユーザーID",
    *                       type="integer"
    *                   ),
    *              )
    *          )
    *      ),
    *      @OA\Response(
    *          response="200",
    *          description="いいね取り消しDB更新",
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(
    *                  property="result",
    *                  description="結果",
    *                  type="boolean"
    *              ),
    *          ),
    *      ),
    *      @OA\Response(
    *          response="500",
    *          description="Internal Server Error",
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(
    *                  property="error",
    *                  type="string",
    *                  example="Internal Server Error"
    *              ),
    *          ),
    *      ),
    * )
    */
    public function remove(LikeRequest $request, RemoveLikeOperation $case):JsonResponse
    {
        $input = $request->validated();
        $result = $case($input);

        if ($result === false) {
            return new JsonResponse([
                'error' => 'Internal Server Error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            'result' => $result,
        ], Response::HTTP_OK);
    }
}
