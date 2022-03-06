<?php
namespace App\Http\UseCase\Department;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\UserRepository;
use App\Services\User\ProfileImageService;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    /** @var ProfileImageService */
    private $profileImageService;

    /** @var DepartmentRepositoryInterface */
    private $departmentRepo;

    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(
        ProfileImageService $profileImageService,
        DepartmentRepositoryInterface $departmentRepo = null,
        UserRepositoryInterface $userRepo = null
    ) {
        $this->profileImageService = $profileImageService;
        $this->departmentRepo = $departmentRepo ?? new DepartmentRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $profileImage = null;

            if (!is_null($input['profile_image'])) {
                $profileImage = $this->profileImageService->saveProfileImage($input['profile_image'], $user->id);
            }

            $department = $this->departmentRepo->find($user->department_id);
            $this->departmentRepo->update($department->id, [
                'name' => $input['name'],
            ]);

            $data = [
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $input['company_id'] ?? $user->company_id,
                'profile_image' => $profileImage ?? 'default.png',
            ];

            if (!is_null($input['email'])) {
                $data['email'] = $input['email'];
            }

            if (!is_null($input['password'])) {
                $data['password'] = Hash::make($input['password']);
            }

            $this->userRepo->update($user->id, $data);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.department.update'));
        return true;
    }
}
