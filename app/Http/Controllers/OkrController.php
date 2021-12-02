<?php

namespace App\Http\Controllers;

use App\Http\Requests\OkrCreateRequest;
use App\Http\Requests\OkrSearchRequest;
use App\Models\Okr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
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
    public function index()
    {
        $okrs = Okr::paginate($this->pagenateNum);

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
        return view('okr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OkrCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OkrCreateRequest $request)
    {
        $input = $request->validated();
        $okr = new Okr();
        // 値の登録
        $okr->year = $request->year;
        $okr->quarter = $request->quarter;
        $okr->okr = $request->okr;
        $okr->objective = $request->objective;
        // 保存
        $okr->save();
        // 登録完了メッセージ
        $request->session()->flash('message', '登録が完了いたしました。');
        // リダイレクト
        return redirect()->route('okr.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
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
