<?php
namespace App\Http\UseCase\OtherOkr;

use App\Repositories\Interfaces\CanEditOtherOkrUserRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CanEditOtherOkrUserRepository;
use App\Repositories\UserRepository;
use DB;
use Flash;
use Illuminate\Support\Facades\Auth;

class UpdateData
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

    public function __invoke(array $input, int $userId): bool
    {
        $this->userRepo->update($userId, [
            'can_edit_other_okr' => is_null($input['can_edit_other_okr']) ? false : (bool) $input['can_edit_other_okr'],
        ]);

        DB::beginTransaction();

        try {
            foreach ($input['target'] as $targetUserId => $isEdit) {
                if ($this->canEditOtherOkrUserRepo->isExists($userId, $targetUserId)) {
                    $canEditOtherOkrUser = $this->canEditOtherOkrUserRepo->findByUserIdAndTargetUserId($userId, $targetUserId);
                    $this->canEditOtherOkrUserRepo->update($canEditOtherOkrUser->id, [
                        'can_edit' => is_null($isEdit) ? false : (bool) $isEdit,
                    ]);
                } else {
                    $this->canEditOtherOkrUserRepo->create([
                        'user_id' => $userId,
                        'target_user_id' => $targetUserId,
                        'can_edit' => is_null($isEdit) ? false : (bool) $isEdit,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Flash::error(__('common/message.other_okr.failed'));
            DB::rollBack();
            return false;
        }

        DB::commit();
        Flash::success(__('common/message.other_okr.update'));
        return true;
    }
}
