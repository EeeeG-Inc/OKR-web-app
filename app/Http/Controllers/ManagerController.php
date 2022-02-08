<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagerStoreRequest;
use App\Http\Requests\ManagerUpdateRequest;
use App\Http\UseCase\Manager\StoreData;
use App\Http\UseCase\Manager\UpdateData;
use Illuminate\Http\RedirectResponse;

class ManagerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param ManagerStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
     */
    public function store(ManagerStoreRequest $request, StoreData $case)
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
     * @param ManagerUpdateRequest $request
     * @param int  $companyId
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(ManagerUpdateRequest $request, UpdateData $case): RedirectResponse
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.edit', $input['user_id']);
        }
        return redirect()->route('dashboard.index');
    }
}
