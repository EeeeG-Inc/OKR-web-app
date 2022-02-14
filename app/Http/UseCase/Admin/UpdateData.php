<?php
namespace App\Http\UseCase\Admin;

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
            $data = [
                'name' => $input['name'],
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

        Flash::success(__('common/message.admin.update'));
        return true;
    }
}
