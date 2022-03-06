<?php
namespace App\Http\UseCase\Member;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\User\UpdateService;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    /** @var UserRepositoryInterface */
    private $userRepo;

    /** @var UpdateService */
    private $updateService;

    public function __construct(UpdateService $updateService, UserRepositoryInterface $userRepo = null)
    {
        $this->updateService = $updateService;
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $data = [
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $input['company_id'],
                'department_id' => $input['department_id'],
            ];

            $data = $this->updateService->appendNullableAttribute($input, $data, $user);
            $this->userRepo->update($user->id, $data);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.member.update'));
        return true;
    }
}
