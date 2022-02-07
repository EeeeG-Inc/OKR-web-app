<?php
namespace App\Http\UseCase\Objective;

use App\Models\KeyResult;
use App\Models\Objective;
use App\Services\Slack\OkrNotificationService;
use DB;
use Flash;
use Illuminate\Support\Facades\Auth;

class DestroyData
{
    private $notifier;

    public function __construct(OkrNotificationService $notifier)
    {
        $this->notifier = $notifier;
    }

    public function __invoke(int $objectiveId): bool
    {
        $user = Auth::user();
        $objective = Objective::find($objectiveId);
        $objectiveName = Objective::find($objectiveId)->objective;

        DB::beginTransaction();

        try {
            KeyResult::where('objective_id', $objectiveId)->delete();
            $objective->delete();
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
