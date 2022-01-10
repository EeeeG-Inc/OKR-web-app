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
            $input['key_result2_id'] ?? -1 => $input['key_result2'],
            $input['key_result3_id'] ?? -2 => $input['key_result3'],
        ];

        $scores = [
            $input['key_result1_id'] => $input['key_result1_score'],
            $input['key_result2_id'] ?? -1 => $input['key_result2_score'],
            $input['key_result3_id'] ?? -2 => $input['key_result3_score'],
        ];

        $remarks = [
            $input['key_result1_id'] => $input['key_result1_remarks'],
            $input['key_result2_id'] ?? -1 => $input['key_result2_remarks'],
            $input['key_result3_id'] ?? -2 => $input['key_result3_remarks'],
        ];

        try {
            $count = 0;
            $totalScore = 0;
            foreach ($keyResults as $id => $keyResult) {
                $k = KeyResult::find($id);
                // 新規作成
                if (!empty($keyResult) && is_null($k)) {
                    KeyResult::create([
                        'user_id' => $input['user_id'],
                        'objective_id' => $objectiveId,
                        'key_result' => $keyResult,
                        'score' => $scores[$id] ?? null,
                        'remarks' => $remarks[$id] ?? null,
                    ]);
                    $count++;
                    $totalScore += $scores[$id] ?? 0;
                // 更新
                } else {
                    if (is_null($k)) {
                        continue;
                    }

                    $k->update([
                        'user_id' => $input['user_id'],
                        'objective_id' => $objectiveId,
                        'key_result' => $keyResult,
                        'score' => $scores[$id] ?? null,
                        'remarks' => $remarks[$id] ?? null,
                    ]);
                    $count++;
                    $totalScore += $scores[$id] ?? 0;
                }

                Objective::find($objectiveId)->update([
                    'user_id' => $input['user_id'],
                    'year' => $input['year'],
                    'quarter_id' => $input['quarter_id'],
                    'objective' => $input['objective'],
                    'score' => round(($totalScore / $count), 2),
                    'remarks' => $input['objective_remarks'],
                ]);
            }
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.objective.update'));
        return true;
    }
}
