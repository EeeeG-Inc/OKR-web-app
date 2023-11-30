<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OtherScoresEditRequest;
use App\Http\Requests\OtherScoresUpdateRequest;
use App\Http\UseCase\OtherScores\GetEditData;
use App\Http\UseCase\OtherScores\UpdateData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OtherScoresController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $userId
     * @param OtherScoresEditRequest $request
     * @param GetEditData $case
     * @return View
     */
    public function edit(int $userId, OtherScoresEditRequest $request, GetEditData $case)
    {
        $input = $request->validated();
        return view(
            'other_scores.edit',
            $case($userId, [
                'year' => $input['year'] ?? null,
                'quarter_id' => $input['quarter_id'] ?? null,
            ])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OtherScoresUpdateRequest $request
     * @param int $userId
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(OtherScoresUpdateRequest $request, int $userId, UpdateData $case)
    {
        $input = $request->validated();

        if (!$case($input, $userId)) {
            return redirect()->route('dashboard.index');
        }
        return redirect()->route('dashboard.index');
    }
}
