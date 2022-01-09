<?php
namespace App\Http\UseCase\Company;

use App\Models\Company;
use App\Models\User;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    public function __construct()
    {
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $companyId = Company::create([
                'name' => $input['name'],
                'is_master' => false,
                'company_group_id' => $user->companies->company_group_id,
            ])->id;

            User::create([
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $companyId,
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.company.store'));
        return true;
    }
}
