<?php

namespace App\Http\Controllers;

use App\Enums\Quarter as Q;
use App\Http\Requests\ObjectiveIndexRequest;
use App\Http\Requests\ObjectiveSearchRequest;
use App\Http\Requests\ObjectiveStoreRequest;
use App\Http\Requests\ObjectiveUpdateRequest;
use App\Http\UseCase\Objective\GetEditData;
use App\Http\UseCase\Objective\GetIndexData;
use App\Http\UseCase\Objective\GetCreateData;
use App\Models\KeyResult;
use App\Models\Objective;
use App\Models\Quarter;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ObjectiveIndexRequest $request
     * @return \Illuminate\View\View
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
     * @return  \Illuminate\View\View
     */
    public function search(ObjectiveSearchRequest $request)
    {
        // $input = $request->validated();
        $objectives = Objective::paginate($this->pagenateNum);

        return view('objective.index', compact('objectives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(GetCreateData $case)
    {
        return view('objective.create', $case());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ObjectiveStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ObjectiveStoreRequest $request)
    {
        $input = $request->validated();

        if (Auth::user()->id !== (int) $input['user_id']) {
            Flash::error(__('validation.user_id'));
            return redirect()->route('objective.create');
        }

        $keyResults = [
            $input['key_result1'],
            $input['key_result2'],
            $input['key_result3'],
        ];

        try {
            $objectiveId = Objective::create([
                'user_id' => $input['user_id'],
                'year' => $input['year'],
                'quarter_id' => $input['quarter_id'],
                'objective' => $input['objective'],
            ])['id'];

            foreach ($keyResults as $keyResult) {
                if (empty($keyResult)) {
                    continue;
                }
                KeyResult::create([
                    'user_id' => $input['user_id'],
                    'objective_id' => $objectiveId,
                    'key_result' => $keyResult,
                ]);
            }
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return redirect()->route('objective.index');
        }
        Flash::success(__('common/message.objective.store'));
        return redirect()->route('objective.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param int $objectiveId
     * @return \Illuminate\View\View
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
     * @return \Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $objectiveId, ObjectiveUpdateRequest $request)
    {
        $input = $request->validated();

        $keyResults = [
            $input['key_result1_id'] => $input['key_result1'],
            $input['key_result2_id'] => $input['key_result2'],
            $input['key_result3_id'] => $input['key_result3'],
        ];

        try {
            Objective::find($objectiveId)->update([
                'user_id' => $input['user_id'],
                'year' => $input['year'],
                'quarter_id' => $input['quarter_id'],
                'objective' => $input['objective'],
            ]);

            foreach ($keyResults as $id => $keyResult) {
                // 新規作成
                if (!empty($keyResult) && KeyResult::find($id) === null) {
                    KeyResult::create([
                        'user_id' => $input['user_id'],
                        'objective_id' => $objectiveId,
                        'key_result' => $keyResult,
                    ]);
                // 更新
                } else {
                    if (KeyResult::find($id) === null) {
                        continue;
                    }

                    KeyResult::find($id)->update([
                        'user_id' => $input['user_id'],
                        'objective_id' => $objectiveId,
                        'key_result' => $keyResult,
                    ]);
                }
            }
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return redirect()->route('objective.index');
        }
        Flash::success(__('common/message.objective.update'));
        return redirect()->route('objective.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $objectiveId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $objectiveId)
    {
        $objective = Objective::find($objectiveId);
        $objectiveName = Objective::find($objectiveId)->objective;

        DB::beginTransaction();

        try {
            KeyResult::where('objective_id', $objectiveId)->delete();
            $objective->delete();
        } catch (\Exception $exc) {
            Flash::error(__('common/message.objective.delete_failed', ['objective' => $objectiveName]));
            DB::rollBack();
        }

        DB::commit();

        Flash::success(__('common/message.objective.delete_success', ['objective' => $objectiveName]));
        return redirect()->route('objective.index');
    }
}
