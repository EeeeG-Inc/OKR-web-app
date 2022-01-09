<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Quarter as Q;
use App\Enums\Role;
use App\Http\Requests\ObjectiveIndexRequest;
use App\Http\Requests\ObjectiveSearchRequest;
use App\Http\Requests\ObjectiveStoreRequest;
use App\Http\Requests\ObjectiveUpdateRequest;
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
    /** @var int */
    private $pagenateNum = 15;

    /**
     * Display a listing of the resource.
     *
     * @param ObjectiveIndexRequest $request
     * @return \Illuminate\View\View
     */
    public function index(ObjectiveIndexRequest $request)
    {
        $input = $request->validated();
        $isLoginUser = false;
        $companyUser = null;
        $departmentUser = null;

        // TODO: 現在ログイン中のユーザに紐づく会社IDの一覧だけを取得するようにする
        if (array_key_exists('user_id', $input)) {
            $user = User::find($input['user_id']);
            $isLoginUser = ($user->id === Auth::id()) ? true : false;
        } else {
            $user = Auth::user();
            $isLoginUser = true;
        }

        if ($user->role === Role::DEPARTMENT) {
            $company = $user->companies()->first();
            $companyUser = User::where('company_id', $company->id)->where('name', $company->name)->first();
        }

        if (($user->role === Role::MANAGER) || ($user->role === Role::MEMBER)) {
            $company = $user->companies()->first();
            $department = $user->departments()->first();
            $companyUser = User::where('company_id', $company->id)->where('name', $company->name)->first();
            $departmentUser = User::where('department_id', $department->id)->where('name', $department->name)->first();
        }

        $objectives = Objective::join('quarters', 'objectives.quarter_id', '=', 'quarters.id')
            ->where('user_id', $user->id)
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'asc')
            ->paginate($this->pagenateNum);
        return view('objective.index', compact('user', 'objectives', 'isLoginUser', 'companyUser', 'departmentUser'));
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
    public function create()
    {
        $user = Auth::user();
        $companyId = $user->companies->id;
        $quarters = Quarter::where('company_id', $companyId)->orderBy('quarter', 'asc')->get();
        // TODO: OKR Facade を作成して登録する。
        $quarterLabels = [
            __('models/quarters.full_year'),
            __('models/quarters.quarter.first_quarter') . '(' . $quarters[0]->from . '月〜' . $quarters[0]->to . '月)',
            __('models/quarters.quarter.second_quarter') . '(' . $quarters[1]->from . '月〜' . $quarters[1]->to . '月)',
            __('models/quarters.quarter.third_quarter') . '(' . $quarters[2]->from . '月〜' . $quarters[2]->to . '月)',
            __('models/quarters.quarter.fourth_quarter') . '(' . $quarters[3]->from . '月〜' . $quarters[3]->to . '月)',
        ];
        $years = $this->getYearsForCreate();

        return view('objective.create', compact('user', 'quarters', 'quarterLabels', 'years'));
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
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
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
    public function edit(int $objectiveId)
    {
        $user = Auth::user();
        $companyId = $user->companies->id;
        $quarters = Quarter::where('company_id', $companyId)->orderBy('quarter', 'asc')->get();

        $objective = Objective::find($objectiveId);
        $keyResluts = KeyResult::where('objective_id', $objectiveId)->get();

        $keyResult1 = $keyResluts[0];
        $keyResult2 = $keyResluts[1] ?? null;
        $keyResult3 = $keyResluts[2] ?? null;

        // TODO: OKR Facade を作成して登録する。
        $quarterLabels = [
            __('models/quarters.full_year'),
            __('models/quarters.quarter.first_quarter') . '(' . $quarters[0]->from . '月〜' . $quarters[0]->to . '月)',
            __('models/quarters.quarter.second_quarter') . '(' . $quarters[1]->from . '月〜' . $quarters[1]->to . '月)',
            __('models/quarters.quarter.third_quarter') . '(' . $quarters[2]->from . '月〜' . $quarters[2]->to . '月)',
            __('models/quarters.quarter.fourth_quarter') . '(' . $quarters[3]->from . '月〜' . $quarters[3]->to . '月)',
        ];

        $year = $objective->year;
        $years = $this->getYearsForEdit($year);

        $quarterId = $objective->quarter_id;
        $quarterChecked = [];

        if ($quarterId === Q::FULL_YEAR_ID) {
            $quarterChecked[0] = true;
        } else {
            $quarterChecked[0] = false;
        }

        $i = 1;

        foreach ($quarters as $quarter) {
            if ($quarter->id === $quarterId) {
                $quarterChecked[$i] = true;
            } else {
                $quarterChecked[$i] = false;
            }
            $i++;
        }

        return view('objective.edit', compact('user', 'quarters', 'quarterLabels', 'years', 'objective', 'keyResult1', 'keyResult2', 'keyResult3', 'year', 'quarterChecked'));
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
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
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
        } catch (\Exception $e) {
            Flash::error(__('common/message.objective.delete_failed', ['objective' => $objectiveName]));
            DB::rollBack();
        }

        DB::commit();

        Flash::success(__('common/message.objective.delete_success', ['objective' => $objectiveName]));
        return redirect()->route('objective.index');
    }

    private function getYearsForCreate(): array
    {
        $prevYear = Carbon::now()->subYear()->format('Y');
        $year = Carbon::now()->format('Y');
        $nextYear = Carbon::now()->addYear()->format('Y');

        return [
            $prevYear => $prevYear,
            $year => $year,
            $nextYear => $nextYear,
        ];
    }

    private function getYearsForEdit(int $year): array
    {
        $date1 = new Carbon($year . '-01-01');
        $date2 = new Carbon($year . '-01-01');

        $prevYear = $date1->subYear()->format('Y');
        $year = $date2->format('Y');
        $nextYear = $date2->addYear()->format('Y');

        return [
            $prevYear => $prevYear,
            $year => $year,
            $nextYear => $nextYear,
        ];
    }
}
