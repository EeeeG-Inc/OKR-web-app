<?php

namespace App\Http\Controllers;

use App\Http\Requests\OkrIndexRequest;
use App\Http\Requests\OkrSearchRequest;
use App\Http\Requests\OkrStoreRequest;
use App\Models\Objective;
use App\Models\Okr;
use App\Models\Quarter;
use App\Models\User;
use \Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OkrController extends Controller
{
    /** @var int */
    private $pagenateNum = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(OkrIndexRequest $request)
    {
        $input = $request->validated();

        // TODO: false の場合は現在ログイン中のユーザIDを使うようにする
        if (array_key_exists('user_id', $input)) {
            $userId = $input['user_id'];
            // TODO: 現在ログイン中のユーザに紐づく会社IDの一覧だけを取得するようにする
            $user = User::find($userId);
            $okrs = Okr::where('user_id', $userId)->get();
            // TODO: index.blade.php にリネームする
            return view('okr.index2', compact('user', 'okrs'));
        }

        $okrs = Okr::paginate($this->pagenateNum);
        // TODO: index.blade2.php を使うようにする
        return view('okr.index', compact('okrs'));
    }

    /**
     * Search listing of the resource.
     *
     * @param OkrSearchRequest $request 検索 Keyword
     * @return  \Illuminate\View\View
     */
    public function search(OkrSearchRequest $request)
    {
        $input = $request->validated();
        $okrs = Okr::paginate($this->pagenateNum);

        return view('okr.index', compact('okrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $companyId = $user->companies->id;
        $quarters = Quarter::where('company_id', $companyId)->get();
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
                Carbon::now()->addYear(2)->format('Y'),
        ];
        return view('okr.create', compact('userId', 'quarters', 'quarterLabels', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OkrStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OkrStoreRequest $request)
    {
        $input = $request->validated();

        if (Auth::id() !== (int) $input['user_id']) {
            $request->session()->flash('message', '不正なユーザIDです。');
            return redirect()->route('okr.create');
        }

        $objectives = [
            $input['objective1'],
            $input['objective2'],
            $input['objective3'],
        ];

        try {
            $okrId = Okr::create([
                'user_id' => $input['user_id'],
                'year' => $input['year'],
                'quarter_id' => $input['quarter'],
                'okr' => $input['okr'],
            ])['id'];

            foreach ($objectives as $objective) {
                if (empty($objective)) {
                    continue;
                }
                Objective::create([
                    'user_id' => $input['user_id'],
                    'okr_id' => $okrId,
                    'objective' => $objective,
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->route('okr.index')->with('error', $e->getMessage());
        }
        return redirect()->route('okr.index')->with('success', 'OKR の登録が完了いたしました。');
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
