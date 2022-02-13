<?php
namespace App\Http\UseCase\Member;

use App\Repositories\Interfaces\UserRepositoryInterface;;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo = null)
    {
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $this->userRepo->create([
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
