<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyGroupUpdateRequest;
use App\Http\UseCase\CompanyGroup\UpdateData;
use App\Http\UseCase\CompanyGroup\GetIndexData;
use Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;

class CompanyGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetIndexData $case
     * @return View|RedirectResponse
     */
    public function index(GetIndexData $case)
    {
        $data = $case();

        if (empty($data)) {
            return redirect()->route('dashboard.index');
        }

        return view('company_group.index', $case());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $companyId
     * @param CompanyGroupUpdateRequest $request
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(int $companyId, CompanyGroupUpdateRequest $request, UpdateData $case)
    {
        $input = $request->validated();

        if (!$case($input, $companyId)) {
            return redirect()->route('company_group.index');
        }
        return redirect()->route('company_group.index');
    }
}
