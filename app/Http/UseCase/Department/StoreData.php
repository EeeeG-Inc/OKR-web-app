<?php
namespace App\Http\UseCase\Department;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    /** @var DepartmentRepositoryInterface */
    private $departmentRepo;

    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo = null, DepartmentRepositoryInterface $departmentRepo = null)
    {
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->departmentRepo = $departmentRepo ?? new DepartmentRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $departmentId = $this->departmentRepo->create([
                'name' => $input['name'],
                'company_id' => $user->company_id,
            ])->id;

            $this->userRepo->create([
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $input['company_id'] ?? $user->company_id,
                'department_id' => $departmentId,
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.department.store'));
        return true;
    }
}
