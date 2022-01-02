<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\DashboardSearchRequest;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
        $user = Auth::user();

        // グループ会社全員のデータを取得する
        $companyIds = Company::where('company_group_id', $user->companies->company_group_id)->pluck('id')->toArray();
        $users = User::where('role', '!=', Role::ADMIN)
            ->whereIn('company_id', $companyIds)
            ->paginate($this->pagenateNum);

        return view('dashboard.index', compact('users'));
    }

    /**
     * Search listing of the resource.
     *
     * @param DashboardSearchRequest $request
     * @return  \Illuminate\View\View
     */
    public function search(DashboardSearchRequest $request)
    {
        // TODO: 現在ログイン中のユーザに紐づく会社IDの一覧だけを取得するようにする
        // $input = $request->validated();
        $users = User::paginate($this->pagenateNum);

        return view('dashboard.index', compact('users'));
    }

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
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    // public function show($userId)
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
