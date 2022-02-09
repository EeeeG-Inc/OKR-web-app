<?php
namespace App\Http\UseCase\Company;

use App\Models\Company;
use App\Models\User;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    public function __construct()
    {
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            Company::find($user->company_id)->update([
                'name' => $input['name'],
            ]);

            $data = [
                'name' => $input['name'],
                'role' => $input['role'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ];

            if (!is_null($input['email'])) {
                $data['email'] = $input['email'];
            }

            if (!is_null($input['password'])) {
                $data['password'] = Hash::make($input['password']);
            }

            $user->update($data);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.company.update'));
        return true;
    }
}
