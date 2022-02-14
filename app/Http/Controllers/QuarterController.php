<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuarterStoreRequest;
use App\Http\Requests\QuarterUpdateRequest;
use App\Http\UseCase\Quarter\GetEditData;
use App\Http\UseCase\Quarter\GetIndexData;
use App\Http\UseCase\Quarter\StoreData;
use App\Http\UseCase\Quarter\UpdateData;
use App\Services\YMD\MonthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuarterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetIndexData $case
     * @return View
     */
    public function index(GetIndexData $case)
    {
        return view('quarter.index', $case());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param MonthService $service
     * @return View
     */
    public function create(MonthService $service)
    {
        $from = $service->createMonthsArray();
        return view('quarter.create', compact('from'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuarterStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
     */
    public function store(QuarterStoreRequest $request, StoreData $case)
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('quarter.create');
        }
        return redirect()->route('quarter.index');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $companyId
     * @param GetEditData $case
     * @return View
     */
    public function edit(int $companyId, GetEditData $case)
    {
        return view('quarter.edit', $case($companyId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuarterUpdateRequest $request
     * @param int $companyId
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(QuarterUpdateRequest $request, int $companyId, UpdateData $case)
    {
        $input = $request->validated();

        if (!$case($input, $companyId)) {
            return redirect()->route('quarter.edit', $companyId);
        }
        return redirect()->route('quarter.index');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
