<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObjectiveIndexRequest;
use App\Models\Objective;
use App\Models\Okr;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(ObjectiveIndexRequest $request)
    {
        $okrId = $request->validated()['okr_id'];
        $okr = Okr::find($okrId);
        $objectives = Objective::where('okr_id', $okrId)->get();

        return view('objective.index', compact('okr', 'objectives'));
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
