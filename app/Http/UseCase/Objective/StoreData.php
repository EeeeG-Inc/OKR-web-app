<?php
namespace App\Http\UseCase\Objective;

use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\KeyResultRepository;
use App\Repositories\ObjectiveRepository;
use Flash;
use Illuminate\Support\Facades\Auth;
use App\Services\Slack\OkrNotificationService;

class StoreData
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

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        if ($user->id !== (int) $input['user_id']) {
            Flash::error(__('validation.user_id'));
            return false;
        }

        $keyResults = [
            $input['key_result1'],
            $input['key_result2'],
            $input['key_result3'],
        ];

        try {
            $objective = $this->objectiveRepo->create([
                'user_id' => $input['user_id'],
                'year' => $input['year'],
                'quarter_id' => $input['quarter_id'],
                'objective' => $input['objective'],
                'priority' => $input['priority'],
            ]);

            foreach ($keyResults as $keyResult) {
                if (empty($keyResult)) {
                    continue;
                }
                $this->keyResultRepo->create([
                    'user_id' => $input['user_id'],
                    'objective_id' => $objective->id,
                    'key_result' => $keyResult,
                ]);
            }

            $text = $this->notifier->getTextWhenCreateOKR($user, $objective);
            $this->notifier->send($user, $text);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.objective.store'));
        return true;
    }
}
