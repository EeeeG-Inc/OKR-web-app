<?php
namespace App\Http\UseCase\Objective;

use App\Models\KeyResult;
use App\Models\Objective;
use Flash;

class UpdateData
{
    public function __construct()
    {
    }

    public function __invoke(array $input, int $objectiveId): bool
    {
        $keyResults = [
            $input['key_result1_id'] => $input['key_result1'],
            $input['key_result2_id'] => $input['key_result2'],
            $input['key_result3_id'] => $input['key_result3'],
        ];

        try {
            Objective::find($objectiveId)->update([
                'user_id' => $input['user_id'],
                'year' => $input['year'],
                'quarter_id' => $input['quarter_id'],
                'objective' => $input['objective'],
            ]);

            foreach ($keyResults as $id => $keyResult) {
                // 新規作成
                if (!empty($keyResult) && KeyResult::find($id) === null) {
                    KeyResult::create([
                        'user_id' => $input['user_id'],
                        'objective_id' => $objectiveId,
                        'key_result' => $keyResult,
                    ]);
                // 更新
                } else {
                    if (KeyResult::find($id) === null) {
                        continue;
                    }

                    KeyResult::find($id)->update([
                        'user_id' => $input['user_id'],
                        'objective_id' => $objectiveId,
                        'key_result' => $keyResult,
                    ]);
                }
            }
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.objective.update'));
        return true;
    }
}
