<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Http\UseCase\Member\StoreData;
use App\Http\UseCase\Member\UpdateData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param MemberStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
     */
    public function store(MemberStoreRequest $request, StoreData $case)
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.create');
        }
        return redirect()->route('dashboard.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberUpdateRequest $request
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(MemberUpdateRequest $request, UpdateData $case): RedirectResponse
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.edit', Auth::id());
        }
        return redirect()->route('dashboard.index');
    }
}
