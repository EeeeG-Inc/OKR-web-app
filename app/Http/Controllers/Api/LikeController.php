<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LikeRequest;
use App\Http\UseCase\Api\Like\LikeOperation;
use App\Http\UseCase\Api\Like\RemoveLikeOperation;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function like(LikeRequest $request, LikeOperation $case)
    {
        $input = $request->validated();
        $case($input);
        return;
    }

    public function remove(LikeRequest $request, RemoveLikeOperation $case)
    {
        $input = $request->validated();
        $case($input);
        return;
    }
}
