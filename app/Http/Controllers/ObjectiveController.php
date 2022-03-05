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
use App\Repositories\ObjectiveRepository;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ObjectiveController extends Controller
{
    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    public function __construct(ObjectiveRepositoryInterface $objectiveRepo = null)
    {
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
    }

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
     * @param ObjectiveSearchRequest $request
     * @param GetIndexData $case
     * @return View
     */
    public function search(ObjectiveSearchRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('objective.index', $case($input));
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
        if (!$case($objectiveId)) {
            return redirect()->route('objective.index');
        }
        return redirect()->route('objective.index');
    }

    /**
     * Archive
     *
     * @param int $objectiveId
     * @return RedirectResponse
     */
    public function archive(int $objectiveId)
    {
        $result = $this->objectiveRepo->update($objectiveId, ['is_archived' => true]);

        if ($result) {
            return redirect()->route('objective.index');
        }
        return redirect()->route('objective.index');
    }

    /**
     * Unarchive
     *
     * @param int $objectiveId
     * @return RedirectResponse
     */
    public function unarchive(int $objectiveId)
    {
        $result = $this->objectiveRepo->update($objectiveId, ['is_archived' => false]);

        if ($result) {
            return redirect()->route('objective.archived_list');
        }
        return redirect()->route('objective.archived_list');
    }

    /**
     * Display a listing of the archive.
     *
     * @param ObjectiveIndexRequest $request
     * @param GetIndexData $case
     * @return View
     */
    public function archivedList(ObjectiveIndexRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('objective.archived_list', $case($input, true));
    }

    /**
     * Search listing of the resource.
     *
     * @param ObjectiveSearchRequest $request
     * @param GetIndexData $case
     * @return View
     */
    public function archiveSearch(ObjectiveSearchRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('objective.archived_list', $case($input, true));
    }
}
