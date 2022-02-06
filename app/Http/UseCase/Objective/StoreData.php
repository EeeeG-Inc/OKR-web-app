<?php
namespace App\Http\UseCase\Objective;

use App\Models\KeyResult;
use App\Models\Objective;
use Flash;
use Illuminate\Support\Facades\Auth;
use App\Services\Slack\OkrNotificationService;

class StoreData
{
    private $notifier;

    public function __construct(OkrNotificationService $notifier)
    {
        $this->notifier = $notifier;
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
            $objective = Objective::create([
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
                KeyResult::create([
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
