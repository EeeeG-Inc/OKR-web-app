<?php
namespace App\Http\UseCase\Objective;

use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\ObjectiveRepository;
use App\Services\OKR\UpdateService;
use App\Services\Slack\OkrNotificationService;
use Flash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    /** @var UpdateService */
    private $updateService;

    /** @var OkrNotificationService */
    private $notifier;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    public function __construct(UpdateService $updateService, OkrNotificationService $notifier, ObjectiveRepositoryInterface $objectiveRepo = null)
    {
        $this->updateService = $updateService;
        $this->notifier = $notifier;
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
    }

    public function __invoke(array $input, int $objectiveId): bool
    {
        $user = Auth::user();

        try {
            $this->updateService->update($input, $objectiveId);
            $text = $this->notifier->getTextWhenUpdateOKR($user, $this->objectiveRepo->find($objectiveId));
            $this->notifier->send($user, $text);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.objective.update'));
        return true;
    }
}
