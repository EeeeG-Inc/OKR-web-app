<?php

namespace App\Services\OKR;

use App\Models\KeyResult;
use App\Models\Objective;
use Exception;

class UpdateService
{
    private $count;
    private $totalScore;

    public function __construct()
    {
        $this->count = 0;
        $this->totalScore = 0;
    }

    public function update(array $input, int $objectiveId): void
    {
        $keyResults = $this->createKeyResultsArray($input);

        foreach ($keyResults as $id => $keyResult) {
            $k = KeyResult::find($id);

            if ($this->isEmptyOnlyKeyResult($keyResult)) {
                throw new \Exception(__('validation.is_empty_only_key_result'));
            }

            if (is_null($k)) {
                $this->createKeyResult($input, $objectiveId, $keyResult);
                $this->countScore($keyResult);
            } else {
                if (is_null($k)) {
                    continue;
                }
                $this->updateKeyResult($k, $input, $objectiveId, $keyResult);
                $this->countScore($keyResult);
            }

            $this->updateObjective($input, $objectiveId);
        }
    }

    private function createKeyResultsArray(array $input): array
    {
        // key_result_id が存在しない場合、確実に存在しないマイナスの id を仕込んでおく: KeyResult::find($id) で null になる
        return [
            $input['key_result1_id'] => [
                'key_result' => $input['key_result1'],
                'score' => $input['key_result1_score'],
                'remarks' => $input['key_result1_remarks'],
            ],
            $input['key_result2_id'] ?? -1 => [
                'key_result' => $input['key_result2'],
                'score' => $input['key_result2_score'],
                'remarks' => $input['key_result2_remarks'],
            ],
            $input['key_result3_id'] ?? -2 => [
                'key_result' => $input['key_result3'],
                'score' => $input['key_result3_score'],
                'remarks' => $input['key_result3_remarks'],
            ],
        ];
    }

    private function createKeyResult(array $input, int $objectiveId, array $keyResult): void
    {
        KeyResult::create([
            'user_id' => $input['user_id'],
            'objective_id' => $objectiveId,
            'key_result' => $keyResult['key_result'],
            'score' => $keyResult['score'] ?? null,
            'remarks' => $keyResult['remarks'] ?? null,
        ]);
    }

    private function updateKeyResult(KeyResult $k, array $input, int $objectiveId, array $keyResult): void
    {
        $k->update([
            'user_id' => $input['user_id'],
            'objective_id' => $objectiveId,
            'key_result' => $keyResult['key_result'],
            'score' => $keyResult['score'] ?? null,
            'remarks' => $keyResult['remarks'] ?? null,
        ]);
    }

    private function updateObjective(array $input, int $objectiveId): void
    {
        Objective::find($objectiveId)->update([
            'user_id' => $input['user_id'],
            'year' => $input['year'],
            'quarter_id' => $input['quarter_id'],
            'objective' => $input['objective'],
            'score' => round(($this->totalScore / $this->count), 2),
            'remarks' => $input['objective_remarks'],
        ]);
    }

    private function countScore(array $keyResult): void
    {
        $this->count++;
        $this->totalScore += $keyResult['score'] ?? 0;
    }

    private function isEmptyOnlyKeyResult(array $keyResult): bool
    {
        return (empty($keyResult['key_result']) && (!empty($keyResult['score']) || !empty($keyResult['remarks'])));
    }
}
