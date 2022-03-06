<?php
namespace App\Http\UseCase\Member;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\User\ProfileImageService;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    /** @var UserRepositoryInterface */
    private $userRepo;

    /** @var ProfileImageService */
    private $profileImageService;

    public function __construct(ProfileImageService $profileImageService, UserRepositoryInterface $userRepo = null)
    {
        $this->profileImageService = $profileImageService;
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

            $data = [
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $input['company_id'],
                'department_id' => $input['department_id'],
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

        Flash::success(__('common/message.member.update'));
        return true;
    }
}
