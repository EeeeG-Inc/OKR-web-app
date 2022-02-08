<?php
namespace App\Http\UseCase\Member;

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

        $data = [
            'name' => $input['name'],
            'role' => $input['role'],
            'company_id' => $input['company_id'],
            'department_id' => $input['department_id'],
        ];

        if (!is_null($input['email'])) {
            $data['email'] = $input['email'];
        }

        if (!is_null($input['password'])) {
            $data['password'] = Hash::make($input['password']);
        }

        try {
            $user->update($data);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.member.update'));
        return true;
    }
}
