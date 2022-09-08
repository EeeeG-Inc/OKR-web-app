<?php

namespace App\Http\Controllers\Api;

use OpenApi\Annotations as OA;
use App\Http\UseCase\Api\Okr\GetMineData;
use App\Http\UseCase\Api\Okr\GetOurData;
use App\Http\Requests\Api\OkrGetMineRequest;
use App\Http\Requests\Api\OkrGetOursRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * @OA\Post(
 *      path="/api/okr/mine/get",
 *      tags={"OKR 取得処理"},
 *      description="自身の OKR を取得する",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  type="object",
 *                  @OA\Property(
 *                      property="year",
 *                      description="西暦",
 *                      type="integer",
 *                      example="2022"
 *                  ),
 *                  @OA\Property(
 *                      property="quarter_id",
 *                      description="四半期ID",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="is_archived",
 *                      description="アーカイブフラグ",
 *                      type="integer",
 *                      example="0"
 *                  ),
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="OKR 取得成功",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(
 *                  property="objectives",
 *                  description="OKR",
 *                  type="object"
 *              ),
 *          ),
 *      ),
 * ),
 * @OA\Post(
 *      path="/api/okr/ours/get",
 *      tags={"会社全体 OKR 取得処理"},
 *      description="ユーザに紐づく会社の全員の OKR を取得する",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  type="object",
 *                  @OA\Property(
 *                      property="year",
 *                      description="西暦",
 *                      type="integer",
 *                      example="2022"
 *                  ),
 *                  @OA\Property(
 *                      property="quarter_id",
 *                      description="四半期ID",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="is_archived",
 *                      description="アーカイブフラグ",
 *                      type="integer",
 *                      example="0"
 *                  ),
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="OKR 取得成功",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(
 *                  property="objectives",
 *                  description="OKR",
 *                  type="object"
 *              ),
 *          ),
 *      ),
 * )
 */
class OkrController extends Controller
{
    /**
     * トークンに紐づくユーザアカウントの OKR を取得する
     *
     * @param OkrGetMineRequest $request
     * @param GetMineData $case
     * @return JsonResponse
     */
    public function getMine(OkrGetMineRequest $request, GetMineData $case): JsonResponse
    {
        $input = $request->validated();
        $result = $case($input);

        return new JsonResponse([
            'objectives' => $result['objectives'],
        ], Response::HTTP_OK);
    }

    /**
     * トークンに紐づく会社の全アカウントの OKR を取得する
     *
     * @param OkrGetOursRequest $request
     * @param GetOurData $case
     * @return JsonResponse
     */
    public function getOurs(OkrGetOursRequest $request, GetOurData $case): JsonResponse
    {
        $input = $request->validated();
        $result = $case($input);
        \Log::debug($input);

        return new JsonResponse([
            'objectives' => $result['objectives'],
        ], Response::HTTP_OK);
    }
}
