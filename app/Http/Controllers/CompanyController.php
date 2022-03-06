<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\UseCase\Company\StoreData;
use App\Http\UseCase\Company\UpdateData;
use \Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
     */
    public function store(CompanyStoreRequest $request, StoreData $case)
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
     * @param CompanyUpdateRequest $request
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(CompanyUpdateRequest $request, UpdateData $case): RedirectResponse
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.edit', Auth::id());
        }
        return redirect()->route('dashboard.index');
    }
}
