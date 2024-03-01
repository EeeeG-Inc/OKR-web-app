<?php
namespace App\Http\UseCase\OtherOkr;

use App\Repositories\Interfaces\CanEditOtherOkrUserRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CanEditOtherOkrUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    /** @var UserRepositoryInterface */
    private $userRepo;

    /** @var CanEditOtherOkrUserRepositoryInterface */
    private $canEditOtherOkrUserRepo;


    public function __construct(
        UserRepositoryInterface $userRepo = null,
        CanEditOtherOkrUserRepositoryInterface $canEditOtherOkrUserRepositoryInterface = null
    ) {
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->canEditOtherOkrUserRepo = $canEditOtherOkrUserRepositoryInterface ?? new CanEditOtherOkrUserRepository();
    }

    public function __invoke(int $userId): array
    {
        $loginUser = Auth::user();
        $users = $this->userRepo->getWhereNotInUserIds([$userId], $loginUser->company_id);
        $canEditOtherOkrUsers = $this->canEditOtherOkrUserRepo->getByUserId($loginUser->id);
        $targetValues = [];

        // DB から設定を取得
        foreach ($canEditOtherOkrUsers as $canEditOtherOkrUser) {
            $targetValues[$canEditOtherOkrUser->target_user_id] = (bool) $canEditOtherOkrUser->can_edit->value;
        }

        // DB に設定がなかったら未設定にしておく
        foreach ($users as $user) {
            if (!array_key_exists($user->id, $targetValues)) {
                $targetValues[$user->id] = false;
            }
        }

        return [
            'user' => $this->userRepo->find($userId),
            'users' => $users,
            'target_values' => $targetValues,
        ];
    }
}
