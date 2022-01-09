<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Department;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    // public function index(Request $request)
    // {
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $user = Auth::user();
        $departments = Department::where('company_id', $user->company_id)->get();
        $departmentNames = [];
        $isMaster = (bool) $user->companies->is_master;
        $role = $user->role;

        if ($departments->isEmpty()) {
            Flash::error(__('validation.not_found_department'));
            $roles = Role::getRolesInWhenCreateUserIfNoDepartment($role, $isMaster);
        } else {
            foreach ($departments as $department) {
                $departmentNames[$department->id] = $department->name;
            }
            $roles = Role::getRolesInWhenCreateUser($role, (bool) $isMaster);
        }

        $companyCreatePermission = false;

        if ($role === Role::ADMIN || (($role === Role::COMPANY) && ($isMaster === true))) {
            $companyCreatePermission = true;
        }

        return view('user.create', compact('user', 'roles', 'departmentNames', 'companyCreatePermission'));
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param UserResultIndexRequest $request
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function store(UserResultIndexRequest $request)
    // {
    //     //
    // }

    /*
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
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
