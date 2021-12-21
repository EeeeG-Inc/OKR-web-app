<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    // public function index(Request $request)
    // {

    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        // TODO:View 実装の際に選択肢は考案
        $roles = [
            Role::DEPARTMENT,
            Role::MANAGER,
            Role::MEMBER,
        ];
        if (Auth::user()->role === 1) {
            $roles = [
                Role::COMPANY,
                Role::DEPARTMENT,
                Role::MANAGER,
                Role::MEMBER,
            ];
        }
        // TODO: DEPARTMENT の文字化けを治す
        $departments = Department::where('company_id', $companyId)->get('name');
        return view('user.create', compact('user', 'companyId', 'roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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
