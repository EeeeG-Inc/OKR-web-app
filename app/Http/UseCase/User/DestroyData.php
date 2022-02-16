<?php
namespace App\Http\UseCase\User;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use DB;
use Flash;

class DestroyData
{
    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo = null)
    {
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function __invoke(int $userId): bool
    {
        $user = $this->userRepo->find($userId);

        DB::beginTransaction();

        try {
            $this->userRepo->delete($user);
        } catch (\Exception $exc) {
            Flash::error(__('common/message.user.delete_failed', ['name' => $user->name]));
            DB::rollBack();
            return false;
        }

        DB::commit();

        Flash::success(__('common/message.user.delete_success', ['name' => $user->name]));
        return true;
    }
}
