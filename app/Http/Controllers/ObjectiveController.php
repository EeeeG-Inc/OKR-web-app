<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObjectiveIndexRequest;
use App\Http\Requests\ObjectiveSearchRequest;
use App\Http\Requests\ObjectiveStoreRequest;
use App\Models\KeyResult;
use App\Models\Objective;
use App\Models\Quarter;
use App\Models\User;
use \Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Flash;

class ObjectiveController extends Controller
{
    /** @var int */
    private $pagenateNum = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(ObjectiveIndexRequest $request)
    {
        $input = $request->validated();

        // TODO: 現在ログイン中のユーザに紐づく会社IDの一覧だけを取得するようにする
        if (array_key_exists('user_id', $input)) {
            $user = User::find($input['user_id']);
        } else {
            $user = Auth::user();
        }
        $userId = $user->id;
        $objectives = Objective::where('user_id', $userId)->paginate($this->pagenateNum);
        return view('objective.index', compact('user', 'objectives'));
    }

    /**
     * Search listing of the resource.
     *
     * @param ObjectiveSearchRequest $request 検索 Keyword
     * @return  \Illuminate\View\View
     */
    public function search(ObjectiveSearchRequest $request)
    {
        $input = $request->validated();
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
            __('models/quarters.quarter.first_quarter') . '('.$quarters[0]->from .'月〜'. $quarters[0]->to .'月)',
            __('models/quarters.quarter.second_quarter') . '('.$quarters[1]->from .'月〜'. $quarters[1]->to .'月)',
            __('models/quarters.quarter.third_quarter') . '('.$quarters[2]->from .'月〜'. $quarters[2]->to .'月)',
            __('models/quarters.quarter.fourth_quarter') . '('.$quarters[3]->from .'月〜'. $quarters[3]->to .'月)'
        ];
        $years = [
                Carbon::now()->format('Y'),
                Carbon::now()->addYear()->format('Y'),
                Carbon::now()->addYears(2)->format('Y'),
        ];
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
                'quarter_id' => $input['quarter'],
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
        Flash::success(__('common/message.register.objective'));
        return redirect()->route('objective.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
