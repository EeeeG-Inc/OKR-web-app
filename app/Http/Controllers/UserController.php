<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\UserResultIndexRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $departments = Department::where('company_id', $user->company_id)->get();
        $departmentNames = [];
        foreach ($departments as $department) {
            $departmentNames[$department->id] = $department->name;
        }
        // 下位 Role の作成が可能
        $roles = Role::getRolesInWhenCreateUser($user->role);
        return view('user.create', compact('user', 'roles', 'departmentNames'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserResultIndexRequest $request)
    {
        $input = $request->validated();
        $user = Auth::user();

        //TODO:Role が admin と company の場合、会社指定の項目が必要なため Blade 含め修正中
        try {
            if ($user->company_id === Role::COMPANY) {
                Company::create([
                    'name' => $input['name'],
                    'is_master' => false,
                    'company_group_id' => $user->company_group_id,
                ]);
            } else if ($input['role'] === Role::DEPARTMENT) {
                Department::create([
                    'name' => $input['name'],
                    'company_id' => $user->company_id,
                ]);
            }
            User::create([
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $user->company_id,
                'department_id' => $input['departments']->id,
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->route('dashboard.index');
        }
        // TODO: 成功メッセージの多言語対応
        Flash::success(__('common/message.register.objective'));
        return redirect()->route('dashboard.index');
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
