<?php

namespace App\Services\OtherScores;

use App\Models\KeyResult;
use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveScoreHistoryRepositoryInterface;
use App\Repositories\KeyResultRepository;
use App\Repositories\ObjectiveRepository;
use App\Repositories\ObjectiveScoreHistoryRepository;

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

    /** @var ObjectiveScoreHistoryRepositoryInterface */
    private $objectiveScoreHistoryRepo;

    public function __construct(
        KeyResultRepositoryInterface $keyResultRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null,
        ObjectiveScoreHistoryRepositoryInterface $objectiveScoreHistoryRepo = null
    ) {
        $this->count = 0;
        $this->totalScore = 0;
        $this->keyResultRepo = $keyResultRepo ?? new KeyResultRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
        $this->objectiveScoreHistoryRepo = $objectiveScoreHistoryRepo ?? new ObjectiveScoreHistoryRepository();
    }

    public function update(array $input, int $objectiveId): void
    {
        // 他のユーザー処理でも参照されるので毎回初期化する
        $this->count = 0;
        $this->totalScore = 0;

        $reqKeyResultsArr = $this->createKeyResultsArray($input);

        foreach ($reqKeyResultsArr as $id => $reqKeyResult) {
            $keyResult = $this->getKeyResult($id);

            // DB に成果指標が存在しない場合
            if (is_null($keyResult) && !is_null($reqKeyResult)) {
                continue;
            }

            // 成果指標が空文字で未設定の場合
            if (empty($keyResult->key_result)) {
                continue;
            }

            $this->updateKeyResult($keyResult->id, $reqKeyResult);
        }

        $this->updateObjective($input, $objectiveId);
    }

    private function createKeyResultsArray(array $input): array
    {
        // key_result_id が存在しない場合、確実に存在しないマイナスの id を仕込んでおく: KeyResult::find($id) で null になる
        return [
            $input['key_result1_id'] => [
                'score' => $input['key_result1_score'],
            ],
            $input['key_result2_id'] ?? -1 => [
                'score' => $input['key_result2_score'],
            ],
            $input['key_result3_id'] ?? -2 => [
                'score' => $input['key_result3_score'],
            ],
        ];
    }

    private function updateKeyResult(int $keyResultId, array $reqKeyResult): void
    {
        $this->keyResultRepo->update($keyResultId, [
            'score' => $reqKeyResult['score'] ?? null,
        ]);

        $this->countScore($reqKeyResult);
    }

    private function updateObjective(array $input, int $objectiveId): void
    {
        $score = round($this->totalScore / $this->count, 2);

        $this->objectiveRepo->update($objectiveId, [
            'score' => $score,
        ]);

        if ($this->objectiveScoreHistoryRepo->isTodayScoreExists($objectiveId)) {
            $history = $this->objectiveScoreHistoryRepo->findByObjectiveId($objectiveId);
            $this->objectiveScoreHistoryRepo->update($history->id, [
                'score' => $score,
            ]);
        } else {
            // 本日スコア履歴がまだなければ作成
            $this->objectiveScoreHistoryRepo->create([
                'objective_id' => $objectiveId,
                'score' => $score,
            ]);
        }
    }

    private function countScore(array $reqKeyResult): void
    {
        if ($reqKeyResult['score'] === '' || is_null($reqKeyResult['score'])) {
            return;
        }
        $this->count++;
        $this->totalScore += $reqKeyResult['score'] ?? 0;
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
