<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Models\Department;
use App\Models\User;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DepartmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DepartmentStoreRequest $request)
    {
        $input = $request->validated();
        $user = Auth::user();

        try {
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
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->route('dashboard.index');
        }

        Flash::success(__('common/message.department.store'));
        return redirect()->route('dashboard.index');
    }
}
