<?php
namespace App\Http\UseCase\Objective;

use App\Models\KeyResult;
use App\Models\Objective;
use Flash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    public function __construct()
    {
    }

    public function __invoke(array $input): bool
    {
        if (Auth::user()->id !== (int) $input['user_id']) {
            Flash::error(__('validation.user_id'));
            return false;
        }

        $keyResults = [
            $input['key_result1'],
            $input['key_result2'],
            $input['key_result3'],
        ];

        try {
            $objectiveId = Objective::create([
                'user_id' => $input['user_id'],
                'year' => $input['year'],
                'quarter_id' => $input['quarter_id'],
                'objective' => $input['objective'],
            ])['id'];

            foreach ($keyResults as $keyResult) {
                if (empty($keyResult)) {
                    continue;
                }
                KeyResult::create([
                    'user_id' => $input['user_id'],
                    'objective_id' => $objectiveId,
                    'key_result' => $keyResult,
                ]);
            }
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.objective.store'));
        return true;
    }
}
