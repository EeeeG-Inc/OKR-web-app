<?php

namespace App\Http\Controllers;

use App\Http\UseCase\KeyResult\GetIndexData;
use App\Http\Requests\KeyResultIndexRequest;
use App\Models\KeyResult;
use App\Models\Objective;

class KeyResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param KeyResultIndexRequest $request
     * @return \Illuminate\View\View
     */
    public function index(KeyResultIndexRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('key_result.index', $case($input));
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /*
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    // public function show(int $id)
    // {
    //     //
    // }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /*
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

    /*
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
