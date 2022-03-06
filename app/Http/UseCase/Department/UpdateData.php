<?php
namespace App\Http\UseCase\Department;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\UserRepository;
use App\Services\User\UpdateService;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    /** @var UpdateService */
    private $updateService;

    /** @var DepartmentRepositoryInterface */
    private $departmentRepo;

    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(
        UpdateService $updateService,
        DepartmentRepositoryInterface $departmentRepo = null,
        UserRepositoryInterface $userRepo = null
    ) {
        $this->updateService = $updateService;
        $this->departmentRepo = $departmentRepo ?? new DepartmentRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $department = $this->departmentRepo->find($user->department_id);
            $this->departmentRepo->update($department->id, [
                'name' => $input['name'],
            ]);

            $data = [
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $input['company_id'] ?? $user->company_id,
            ];

            $data = $this->updateService->appendNullableAttribute($input, $data, $user);
            $this->userRepo->update($user->id, $data);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.department.update'));
        return true;
    }
}
