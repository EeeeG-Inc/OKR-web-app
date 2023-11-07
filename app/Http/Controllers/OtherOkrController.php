<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OtherOkrUpdateRequest;
use App\Http\UseCase\OtherOkr\GetIndexData;
use App\Http\UseCase\OtherOkr\GetEditData;
use App\Http\UseCase\OtherOkr\UpdateData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OtherOkrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetIndexData $case
     * @return View
     */
    public function index(GetIndexData $case): View
    {
        return view('other_okr.index', $case());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $userId
     * @param GetEditData $case
     * @return View
     */
    public function edit(int $userId, GetEditData $case)
    {
        return view('other_okr.edit', $case($userId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuarterUpdateRequest $request
     * @param int $userId
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(OtherOkrUpdateRequest $request, int $userId, UpdateData $case)
    {
        $input = $request->validated();

        if (!$case($input, $userId)) {
            return redirect()->route('other_okr.index');
        }
        return redirect()->route('other_okr.index');
    }
}
