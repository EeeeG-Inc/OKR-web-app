<?php

namespace App\Http\Controllers;

use App\Http\UseCase\User\GetCreateData;
use App\Http\UseCase\User\GetEditData;
use App\Http\UseCase\User\DestroyData;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param GetCreateData $case
     * @return View
     */
    public function create(GetCreateData $case)
    {
        return view('user.create', $case());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $userId
     * @param GetEditData $case
     * @return View
     */
    public function edit(int $userId, GetEditData $case): View
    {
        return view('user.edit', $case());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @param DestroyData $case
     * @return RedirectResponse
     */
    public function destroy(int $userId, DestroyData $case)
    {
        $this->authorize('delete', Auth::user());

        if (!$case($userId)) {
            return redirect()->route('objective.index');
        }
        return redirect()->route('objective.index');
    }
}
