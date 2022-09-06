<?php

namespace App\Http\Controllers\Api;

use OpenApi\Annotations as OA;
use App\Http\UseCase\Api\Quarter\GetData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 *  @OA\Post(
 *      path="/api/quarter/get",
 *      tags={"四半期取得処理"},
 *      description="自身の会社に紐づく四半期情報を取得する",
 *      @OA\Response(
 *          response="200",
 *          description="四半期一覧取得成功",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(
 *                  property="quarters",
 *                  description="四半期",
 *                  type="object"
 *              ),
 *          ),
 *      ),
 *  )
 */
class QuarterController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param GetData $case
     * @return JsonResponse
     */
    public function get(Request $request, GetData $case): JsonResponse
    {
        $result = $case();

        return new JsonResponse([
            'quarters' => $result['quarters'],
        ], Response::HTTP_OK);
    }
}
