<?php

namespace App\Http\Controllers;

use App\Http\Requests\OkrIndexRequest;
use App\Http\Requests\OkrSearchRequest;
use App\Models\Okr;
use App\Models\User;

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
        $userId = $request->validated()['user_id'];

        if ($userId) {
            $user = User::find($userId);
            $okrs = Okr::where('user_id', $userId)->get();
            // TODO: index.blade.php にリネームする
            return view('okr.index2', compact('user', 'okrs'));
        }

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

    // public function okrlist(Request $request)
    // {
    //     $title = Request::get('name');

    //     if ($title) {
    //         $item = Okr::where('name', 'LIKE', "%$name%")->simplePaginate($this->pagenateNum);
    //     } else {
    //         $item = Okr::select('*')->simplePaginate($this->pagenateNum);
    //         //default は全件表示
    //         $title='全件表示';
    //     }
    //     return view('okrlist', ['items'=>$item])->with('title', $title);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

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
