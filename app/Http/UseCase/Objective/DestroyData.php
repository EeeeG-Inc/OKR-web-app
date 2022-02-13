<?php
namespace App\Http\UseCase\Objective;

use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\KeyResultRepository;
use App\Repositories\ObjectiveRepository;
use App\Services\Slack\OkrNotificationService;
use DB;
use Flash;
use Illuminate\Support\Facades\Auth;

class DestroyData
{
    /** @var OkrNotificationService */
    private $notifier;

    /** @var KeyResultRepositoryInterface */
    private $keyResultRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    public function __construct(
        OkrNotificationService $notifier,
        KeyResultRepositoryInterface $keyResultRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null
    ) {
        $this->notifier = $notifier;
        $this->keyResultRepo = $keyResultRepo ?? new KeyResultRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
    }

    public function __invoke(int $objectiveId): bool
    {
        $user = Auth::user();
        $objective = $this->objectiveRepo->find($objectiveId);
        $objectiveName = $objective->objective;

        DB::beginTransaction();

        try {
            $keyResults = $this->keyResultRepo->getByObjectiveId($objectiveId);
            foreach ($keyResults as $keyResult) {
                $this->keyResultRepo->delete($keyResult);
            }
            $this->objectiveRepo->delete($objective);

            $text = $this->notifier->getTextWhenDestroyOKR($user, $objective);
            $this->notifier->send($user, $text);
        } catch (\Exception $exc) {
            Flash::error(__('common/message.objective.delete_failed', ['objective' => $objectiveName]));
            DB::rollBack();
            return false;
        }

        DB::commit();

        Flash::success(__('common/message.objective.delete_success', ['objective' => $objectiveName]));
        return true;
    }
}
