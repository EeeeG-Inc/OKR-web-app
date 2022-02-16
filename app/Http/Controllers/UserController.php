<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardSearchRequest;
use App\Http\UseCase\Dashboard\GetIndexData;
use App\Http\UseCase\User\GetCreateData;
use App\Http\UseCase\User\GetEditData;
use App\Http\UseCase\User\DestroyData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DashboardSearchRequest $request
     * @param GetIndexData $case
     * @return View
     */
    public function index(DashboardSearchRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('user.index', $case($input));
    }

    /**
     * Search listing of the resource.
     *
     * @param DashboardSearchRequest $request
     * @param GetIndexData $case
     * @return View
     */
    public function search(DashboardSearchRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('user.index', $case($input));
    }

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
    public function destroy(int $userId, DestroyData $case): RedirectResponse
    {
        $this->authorize('delete', Auth::user());

        if (!$case($userId)) {
            return redirect()->route('user.index');
        }
        return redirect()->route('user.index');
    }
}
