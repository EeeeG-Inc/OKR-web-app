<?php

namespace App\Http\Controllers;

use App\Http\UseCase\KeyResult\GetIndexData;
use App\Http\Requests\KeyResultIndexRequest;
use Illuminate\View\View;

class KeyResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param KeyResultIndexRequest $request
     * @param GetIndexData $case
     * @return View
     */
    public function index(KeyResultIndexRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('key_result.index', $case($input));
    }
}
