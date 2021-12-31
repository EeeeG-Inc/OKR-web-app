<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use App\Models\User;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CompanyStoreRequest $request)
    {
        $input = $request->validated();
        $user = Auth::user();

        try {
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
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->route('dashboard.index');
        }

        Flash::success(__('common/message.company.store'));
        return redirect()->route('dashboard.index');
    }
}
