<?php
namespace App\Http\UseCase\Company;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Services\User\ProfileImageService;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    /** @var ProfileImageService */
    private $profileImageService;

    /** @var CompanyRepositoryInterface */
    private $companyRepo;


    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(
        ProfileImageService $profileImageService,
        CompanyRepositoryInterface $companyRepo = null,
        UserRepositoryInterface $userRepo = null
    ) {
        $this->profileImageService = $profileImageService;
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
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

            $this->companyRepo->find($user->company_id)->update([
                'name' => $input['name'],
            ]);

            $data = [
                'name' => $input['name'],
                'role' => $input['role'],
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

        Flash::success(__('common/message.company.update'));
        return true;
    }
}
