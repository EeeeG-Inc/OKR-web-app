<?php

namespace App\Services\OKR;

use App\Models\KeyResult;
use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\KeyResultRepository;
use App\Repositories\ObjectiveRepository;

class UpdateService
{
    /** @var int */
    private $count;

    /** @var int */
    private $totalScore;

    /** @var KeyResultRepositoryInterface */
    private $keyResultRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    public function __construct(KeyResultRepositoryInterface $keyResultRepo = null, ObjectiveRepositoryInterface $objectiveRepo = null)
    {
        $this->count = 0;
        $this->totalScore = 0;
        $this->keyResultRepo = $keyResultRepo ?? new KeyResultRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
    }

    public function update(array $input, int $objectiveId): void
    {
        $reqKeyResultsArr = $this->createKeyResultsArray($input);

        foreach ($reqKeyResultsArr as $id => $reqKeyResult) {
            if ($this->isEmptyOnlyKeyResult($reqKeyResult)) {
                throw new \Exception(__('validation.is_empty_only_key_result'));
            }

            $keyResult = $this->getKeyResult($id);

            if (is_null($keyResult) && !is_null($reqKeyResult)) {
                $this->createKeyResult($input, $objectiveId, $reqKeyResult);
            } else {
                $this->updateKeyResult($keyResult->id, $input, $objectiveId, $reqKeyResult);
            }
        }

        $this->updateObjective($input, $objectiveId);
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

    private function createKeyResult(array $input, int $objectiveId, array $reqKeyResult): void
    {
        // 成果指標は必須
        if (is_null($reqKeyResult['key_result'])) {
            return;
        }

        $this->keyResultRepo->create([
            'user_id' => $input['user_id'],
            'objective_id' => $objectiveId,
            'key_result' => $reqKeyResult['key_result'],
            'score' => $reqKeyResult['score'] ?? null,
            'remarks' => $reqKeyResult['remarks'] ?? null,
        ]);

        $this->countScore($reqKeyResult);
    }

    private function updateKeyResult(int $keyResultId, array $input, int $objectiveId, array $reqKeyResult): void
    {
        $this->keyResultRepo->update($keyResultId, [
            'user_id' => $input['user_id'],
            'objective_id' => $objectiveId,
            'key_result' => $reqKeyResult['key_result'],
            'score' => $reqKeyResult['score'] ?? null,
            'remarks' => $reqKeyResult['remarks'] ?? null,
        ]);

        $this->countScore($reqKeyResult);
    }

    private function updateObjective(array $input, int $objectiveId): void
    {
        $this->objectiveRepo->update($objectiveId, [
            'user_id' => $input['user_id'],
            'year' => $input['year'],
            'quarter_id' => $input['quarter_id'],
            'objective' => $input['objective'],
            'score' => round($this->totalScore / $this->count, 2),
            'remarks' => $input['objective_remarks'],
            'priority' => $input['priority'],
        ]);
    }

    private function countScore(array $reqKeyResult): void
    {
        $this->count++;
        $this->totalScore += $reqKeyResult['score'] ?? 0;
    }

    private function isEmptyOnlyKeyResult(array $reqKeyResult): bool
    {
        return empty($reqKeyResult['key_result']) && (!empty($reqKeyResult['score']) || !empty($reqKeyResult['remarks']));
    }

    private function getKeyResult(int $id): ?KeyResult
    {
        $keyResult = null;

        if ($id >= 1) {
            $keyResult = $this->keyResultRepo->find($id);
        }

        return $keyResult;
    }
}
