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
use Illuminate\Support\Facades\Gate;
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
        $roles = Role::getRolesInWhenCreateUser($user->role, $user->companies->is_master);

        $companyCreatePermission = false;
        if (Gate::allows('admin-only') || $user->companies->is_master === true) {
            $companyCreatePermission = true;
        }
        return view('user.create', compact('user', 'roles', 'departmentNames', 'companyCreatePermission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserResultIndexRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserResultIndexRequest $request)
    {
        $input = $request->validated();
        $user = Auth::user();

        try {
            if ($input['role']  === Role::COMPANY) {
                $companyId = Company::create([
                    'name' => $input['name'],
                    'is_master' => false,
                    'company_group_id' => $user->company_group_id,
                ])->id;
                User::create([
                    'name' => $input['name'],
                    'role' => $input['role'],
                    'company_id' => $companyId,
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                ]);
            } else if ($input['role'] === Role::DEPARTMENT) {
                $departmentId = Department::create([
                    'name' => $input['name'],
                    'company_id' => $user->company_id,
                ])->id;
                User::create([
                    'name' => $input['name'],
                    'role' => $input['role'],
                    'company_id' => $user->company_id,
                    'department_id' => $departmentId,
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
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
