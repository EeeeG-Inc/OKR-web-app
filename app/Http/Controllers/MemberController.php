<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\MemberStoreRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param MemberResultIndexRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MemberStoreRequest $request)
    {
        $input = $request->validated();
        $user = Auth::user();

        try {
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
}