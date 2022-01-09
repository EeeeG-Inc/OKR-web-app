<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ManagerStoreRequest;
use App\Models\User;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param ManagerStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ManagerStoreRequest $request)
    {
        $input = $request->validated();
        $user = Auth::user();

        try {
            User::create([
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $user->company_id,
                'department_id' => $input['department_id'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->route('dashboard.index');
        }

        Flash::success(__('common/message.manager.store'));
        return redirect()->route('dashboard.index');
    }
}
