<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObjectiveIndexRequest;
use App\Http\Requests\ObjectiveSearchRequest;
use App\Http\Requests\ObjectiveStoreRequest;
use App\Http\Requests\ObjectiveUpdateRequest;
use App\Http\UseCase\Objective\DestroyData;
use App\Http\UseCase\Objective\StoreData;
use App\Http\UseCase\Objective\UpdateData;
use App\Http\UseCase\Objective\GetEditData;
use App\Http\UseCase\Objective\GetIndexData;
use App\Http\UseCase\Objective\GetCreateData;
use App\Models\Objective;
use Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ObjectiveIndexRequest $request
     * @param GetIndexData $case
     * @return View
     */
    public function index(ObjectiveIndexRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('objective.index', $case($input));
    }

    /**
     * Search listing of the resource.
     *
     * @param ObjectiveSearchRequest $request 検索 Keyword
     * @return View
     */
    public function search(ObjectiveSearchRequest $request)
    {
        // $input = $request->validated();
        $objectives = Objective::paginate(15);

        return view('objective.index', compact('objectives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param GetCreateData $case
     * @return View
     */
    public function create(GetCreateData $case)
    {
        return view('objective.create', $case());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ObjectiveStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
     */
    public function store(ObjectiveStoreRequest $request, StoreData $case)
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('objective.create');
        }

        return redirect()->route('objective.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param int $objectiveId
     * @return View
     */
    // public function show(int $id)
    // {
    //     $user = User::find($userId);
    //     $okrs = Okr::where('user_id', $userId)->get();

    //     return view('okr.show', compact('user', 'okrs'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $objectiveId
     * @param GetEditData $case
     * @return View
     */
    public function edit(int $objectiveId, GetEditData $case)
    {
        return view('objective.edit', $case($objectiveId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int                    $objectiveId
     * @param ObjectiveUpdateRequest $request
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(int $objectiveId, ObjectiveUpdateRequest $request, UpdateData $case)
    {
        $input = $request->validated();

        if (!$case($input, $objectiveId)) {
            return redirect()->route('objective.edit', $objectiveId);
        }

        return redirect()->route('objective.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $objectiveId
     * @param DestroyData $case
     * @return RedirectResponse
     */
    public function destroy(int $objectiveId, DestroyData $case)
    {
        $isScuccess = $case($objectiveId);

        if (!$isScuccess) {
            return redirect()->route('objective.index');
        }

        return redirect()->route('objective.index');
    }
}
