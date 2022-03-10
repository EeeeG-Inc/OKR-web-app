<?php

namespace App\Http\Controllers;

use App\Http\UseCase\KeyResult\GetIndexData;
use App\Http\UseCase\KeyResult\DestroyComment;
use App\Http\UseCase\KeyResult\StoreComment;
use App\Http\Requests\KeyResultIndexRequest;
use App\Http\Requests\KeyResultCommentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Flash;

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

    /**
     * @param KeyResultCommentRequest $request
     * @param StoreComment $case
     * @return RedirectResponse
     */
    public function comment(KeyResultCommentRequest $request, StoreComment $case)
    {
        $input = $request->validated();
        $case($input);
        return redirect()->route('key_result.index')->withInput([
            'objective_id' => $input['objective_id'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $commentId
     * @param int $objectiveId
     * @param DestroyComment $case
     * @return RedirectResponse
     */
    public function destroyComment(int $commentId, int $objectiveId, DestroyComment $case)
    {
        $case($commentId, $objectiveId);
        return redirect()->route('key_result.index')->withInput([
            'objective_id' => $objectiveId,
        ]);
    }
}
