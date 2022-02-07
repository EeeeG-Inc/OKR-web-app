<?php
namespace App\Http\UseCase\Member;

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
            User::create([
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $input['company_id'] ?? $user->company_id,
                'department_id' => $input['department_id'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.member.store'));
        return true;
    }
}
