<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardSearchRequest;
use App\Http\UseCase\Dashboard\GetIndexData;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetIndexData $case
     * @return View
     */
    public function index(GetIndexData $case)
    {
        return view('dashboard.index', $case());
    }

    /**
     * Search listing of the resource.
     *
     * @param DashboardSearchRequest $request
     * @return View
     */
    public function search(DashboardSearchRequest $request)
    {
        // TODO: 現在ログイン中のユーザに紐づく会社IDの一覧だけを取得するようにする
        // $input = $request->validated();
        $users = User::paginate(15);

        return view('dashboard.index', compact('users'));
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
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    // public function show($userId)
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
