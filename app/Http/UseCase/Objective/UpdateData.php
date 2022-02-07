<?php
namespace App\Http\UseCase\Objective;

use App\Models\Objective;
use App\Services\OKR\UpdateService;
use App\Services\Slack\OkrNotificationService;
use Flash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    private $updateService;
    private $notifier;

    public function __construct(UpdateService $updateService, OkrNotificationService $notifier)
    {
        $this->updateService = $updateService;
        $this->notifier = $notifier;
    }

    public function __invoke(array $input, int $objectiveId): bool
    {
        $user = Auth::user();

        try {
            $this->updateService->update($input, $objectiveId);
            $text = $this->notifier->getTextWhenUpdateOKR($user, Objective::find($objectiveId));
            $this->notifier->send($user, $text);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.objective.update'));
        return true;
    }
}
