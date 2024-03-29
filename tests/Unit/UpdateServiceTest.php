<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\OKR\UpdateService;
use App\Models\KeyResult;
use App\Models\Objective;
use App\Models\ObjectiveScoreHistory;
use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveScoreHistoryRepositoryInterface;
use Carbon\CarbonImmutable;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class UpdateServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var KeyResultRepositoryInterface */
    private $keyResultRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    /** @var ObjectiveScoreHistoryRepositoryInterface */
    private $objectiveScoreHistoryRepo;

    /** @var UpdateService */
    private $updateService;

    /** @var KeyResult */
    private $keyResult1;

    /** @var KeyResult */
    private $keyResult2;

    /** @var KeyResult */
    private $keyResult3;

    /** @var Objective */
    private $objective;

    /** @var ObjectiveScoreHistory */
    private $objectiveScoreHistory;

    public function setUp(): void
    {
        parent::setUp();
        CarbonImmutable::setTestNow(CarbonImmutable::now());
        /** @var KeyResultRepositoryInterface  */
        $this->keyResultRepo = m::mock(KeyResultRepositoryInterface::class);
        /** @var ObjectiveRepositoryInterface  */
        $this->objectiveRepo = m::mock(ObjectiveRepositoryInterface::class);
        /** @var ObjectiveScoreHistoryRepositoryInterface  */
        $this->objectiveScoreHistoryRepo = m::mock(ObjectiveScoreHistoryRepositoryInterface::class);

        // model の mock
        $this->keyResult1 = m::mock(KeyResult::class);
        $this->keyResult2 = m::mock(KeyResult::class);
        $this->keyResult3 = m::mock(KeyResult::class);
        $this->objective = m::mock(Objective::class);
        $this->objectiveScoreHistory = m::mock(ObjectiveScoreHistory::class);

        $this->keyResult1->allows('getAttribute')->with('id')->andReturn(1);
        $this->keyResult1->allows('offsetExists')->andReturn(true);

        $this->keyResult2->allows('getAttribute')->with('id')->andReturn(2);
        $this->keyResult2->allows('offsetExists')->andReturn(true);

        $this->keyResult3->allows('getAttribute')->with('id')->andReturn(3);
        $this->keyResult3->allows('offsetExists')->andReturn(true);

        $this->objective->allows('getAttribute')->with('id')->andReturn(1);
        $this->objective->allows('getAttribute')->with('objective')->andReturn('テスト目標');
        $this->objective->allows('getAttribute')->with('remarks')->andReturn('テスト備考');
        $this->objective->allows('getAttribute')->with('impression')->andReturn('所感');
        $this->objective->allows('getAttribute')->with('priority')->andReturn(1);
        $this->objective->allows('getAttribute')->with('quarter_id')->andReturn(1);
        $this->objective->allows('getAttribute')->with('user_id')->andReturn(1);
        $this->objective->allows('getAttribute')->with('year')->andReturn(2022);
        $this->objective->allows('getAttribute')->with('score')->andReturn(1);
    }
    public function tearDown(): void
    {
        parent::tearDown();
        CarbonImmutable::setTestNow();
    }

    /**
     * 成果指標 1 つ持つ目標のスコア確認
     */
    public function testObjectiveScoreOfOneKeyResultsPatternSuccessfully(): void
    {
        $keyResult1 = [
            'id' => $this->keyResult1->id,
            'key_result' => '成果指標1',
            'score' => 0.5,
            'remarks' => 'テスト1',
            'impression' => '所感1',
        ];
        $keyResult2 = [
            'id' => null,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
            'impression' => null,
        ];
        $keyResult3 = [
            'id' => null,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
            'impression' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'objective_impression' => $this->objective->impression,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result1_impression' => $keyResult1['impression'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result2_impression' => $keyResult2['impression'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
            'key_result3_impression' => $keyResult3['impression'],
        ];

        // mock set
        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult1->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult1['key_result'],
                'score' => $keyResult1['score'],
                'remarks' => $keyResult1['remarks'],
                'impression' => $keyResult1['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult1->id)
            ->andReturn($this->keyResult1);

        $this->objectiveRepo->shouldReceive('update')
            ->once()
            ->with($this->objective->user_id, [
                'user_id' => $this->objective->user_id,
                'year' => $this->objective->year,
                'quarter_id' => $this->objective->quarter_id,
                'objective' => $this->objective->objective,
                'score' => $keyResult1['score'],
                'remarks' => $this->objective->remarks,
                'impression' => $this->objective->impression,
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        $this->objectiveScoreHistoryRepo->shouldReceive('isTodayScoreExists')
            ->once()
            ->andReturn(false);

        $this->objectiveScoreHistoryRepo->shouldReceive('create')
            ->once()
            ->with([
                'objective_id' => $this->objective->id,
                'score' => $keyResult1['score'],
            ])
            ->andReturn($this->objectiveScoreHistory);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo,
            $this->objectiveScoreHistoryRepo
        );

        $result = $this->updateService->update($input, $this->objective->id);
        $this->assertSame($result, null);
    }

    /**
     * 成果指標 2 つ持つ目標のスコア確認
     */
    public function testObjectiveScoreOfTwoKeyResultsPatternSuccessfully(): void
    {
        $keyResult1 = [
            'id' => $this->keyResult1->id,
            'key_result' => '成果指標1',
            'score' => 0.5,
            'remarks' => '備考1',
            'impression' => '所感1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => '成果指標2',
            'score' => '0.5',
            'remarks' => '備考2',
            'impression' => '所感2',
        ];
        $keyResult3 = [
            'id' => null,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
            'impression' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'objective_impression' => $this->objective->impression,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result1_impression' => $keyResult1['impression'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result2_impression' => $keyResult2['impression'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
            'key_result3_impression' => $keyResult3['impression'],
        ];

        // mock set
        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult1->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult1['key_result'],
                'score' => $keyResult1['score'],
                'remarks' => $keyResult1['remarks'],
                'impression' => $keyResult1['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult1->id)
            ->andReturn($this->keyResult1);

        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult2->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult2['key_result'],
                'score' => $keyResult2['score'],
                'remarks' => $keyResult2['remarks'],
                'impression' => $keyResult2['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult2->id)
            ->andReturn($this->keyResult2);

        $this->objectiveRepo->shouldReceive('update')
            ->once()
            ->with($this->objective->user_id, [
                'user_id' => $this->objective->user_id,
                'year' => $this->objective->year,
                'quarter_id' => $this->objective->quarter_id,
                'objective' => $this->objective->objective,
                'score' => ($keyResult1['score'] + $keyResult2['score']) / 2,
                'remarks' => $this->objective->remarks,
                'impression' => $this->objective->impression,
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        $this->objectiveScoreHistoryRepo->shouldReceive('isTodayScoreExists')
            ->once()
            ->andReturn(false);

        $this->objectiveScoreHistoryRepo->shouldReceive('create')
            ->once()
            ->with([
                'objective_id' => $this->objective->id,
                'score' => ($keyResult1['score'] + $keyResult2['score']) / 2,
            ])
            ->andReturn($this->objectiveScoreHistory);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo,
            $this->objectiveScoreHistoryRepo
        );
        $result = $this->updateService->update($input, $this->objective->id);
        $this->assertSame($result, null);
    }

    /**
     * 成果指標 3 つ持つ目標のスコア確認
     */
    public function testObjectiveScoreOfThreeKeyResultsPatternSuccessfully(): void
    {
        $keyResult1 = [
            'id' => $this->keyResult1->id,
            'key_result' => '成果指標1',
            'score' => '0.5',
            'remarks' => '備考1',
            'impression' => '所感1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => '成果指標2',
            'score' => '0.5',
            'remarks' => '備考2',
            'impression' => '所感2',
        ];
        $keyResult3 = [
            'id' => $this->keyResult3->id,
            'key_result' => '成果指標3',
            'score' => '0.5',
            'remarks' => '所感3',
            'impression' => '所感3',
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'objective_impression' => $this->objective->impression,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result1_impression' => $keyResult1['impression'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result2_impression' => $keyResult2['impression'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
            'key_result3_impression' => $keyResult3['impression'],
        ];

        // mock set
        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult1->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult1['key_result'],
                'score' => $keyResult1['score'],
                'remarks' => $keyResult1['remarks'],
                'impression' => $keyResult1['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult1->id)
            ->andReturn($this->keyResult1);

        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult2->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult2['key_result'],
                'score' => $keyResult2['score'],
                'remarks' => $keyResult2['remarks'],
                'impression' => $keyResult2['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult2->id)
            ->andReturn($this->keyResult2);

        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult3->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult3['key_result'],
                'score' => $keyResult3['score'],
                'remarks' => $keyResult3['remarks'],
                'impression' => $keyResult3['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult3->id)
            ->andReturn($this->keyResult3);

        $this->objectiveRepo->shouldReceive('update')
            ->once()
            ->with($this->objective->user_id, [
                'user_id' => $this->objective->user_id,
                'year' => $this->objective->year,
                'quarter_id' => $this->objective->quarter_id,
                'objective' => $this->objective->objective,
                'score' => ($keyResult1['score'] + $keyResult2['score'] + $keyResult3['score']) / 3,
                'remarks' => $this->objective->remarks,
                'impression' => $this->objective->impression,
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        $this->objectiveScoreHistoryRepo->shouldReceive('isTodayScoreExists')
            ->once()
            ->andReturn(false);

        $this->objectiveScoreHistoryRepo->shouldReceive('create')
            ->once()
            ->with([
                'objective_id' => $this->objective->id,
                'score' => ($keyResult1['score'] + $keyResult2['score'] + $keyResult3['score']) / 3,
            ])
            ->andReturn($this->objectiveScoreHistory);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo,
            $this->objectiveScoreHistoryRepo
        );
        $result = $this->updateService->update($input, $this->objective->id);
        $this->assertSame($result, null);
    }

    /**
     * 成果指標 3 つの状態で 1 つ削除した場合のスコア確認
     */
    public function testThreeKeyResultsDeleteOneKeyResultPatternSuccessfully(): void
    {
        $keyResult1 = [
            'id' => $this->keyResult1->id,
            'key_result' => '成果指標1',
            'score' => 1.0,
            'remarks' => '備考1',
            'impression' => '所感1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => '成果指標2',
            'score' => 1.0,
            'remarks' => '備考2',
            'impression' => '所感2',
        ];
        $keyResult3 = [
            'id' => $this->keyResult3->id,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
            'impression' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'objective_impression' => $this->objective->impression,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result1_impression' => $keyResult1['impression'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result2_impression' => $keyResult2['impression'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
            'key_result3_impression' => $keyResult3['impression'],
        ];

        // mock set
        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult1->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult1['key_result'],
                'score' => $keyResult1['score'],
                'remarks' => $keyResult1['remarks'],
                'impression' => $keyResult1['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult1->id)
            ->andReturn($this->keyResult1);

        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult2->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult2['key_result'],
                'score' => $keyResult2['score'],
                'remarks' => $keyResult2['remarks'],
                'impression' => $keyResult2['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult2->id)
            ->andReturn($this->keyResult2);

        $this->objectiveRepo->shouldReceive('update')
            ->once()
            ->with($this->objective->user_id, [
                'user_id' => $this->objective->user_id,
                'year' => $this->objective->year,
                'quarter_id' => $this->objective->quarter_id,
                'objective' => $this->objective->objective,
                'score' => ($keyResult1['score'] + $keyResult2['score']) / 2,
                'remarks' => $this->objective->remarks,
                'impression' => $this->objective->impression,
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult3->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult3['key_result'],
                'score' => $keyResult3['score'],
                'remarks' => $keyResult3['remarks'],
                'impression' => $keyResult3['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult3->id)
            ->andReturn($this->keyResult3);

        $this->objectiveScoreHistoryRepo->shouldReceive('isTodayScoreExists')
            ->once()
            ->andReturn(false);

        $this->objectiveScoreHistoryRepo->shouldReceive('create')
            ->once()
            ->with([
                'objective_id' => $this->objective->id,
                'score' => ($keyResult1['score'] + $keyResult2['score']) / 2,
            ])
            ->andReturn($this->objectiveScoreHistory);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo,
            $this->objectiveScoreHistoryRepo
        );
        $result = $this->updateService->update($input, $this->objective->id);
        $this->assertSame($result, null);
    }

    /**
     * 成果指標 3 つの状態で 2 つ削除した場合のスコア確認
     */
    public function testThreeKeyResultsDeleteTwoKeyResultPatternSuccessfully(): void
    {
        $keyResult1 = [
            'id' => $this->keyResult1->id,
            'key_result' => '成果指標1',
            'score' => 1.0,
            'remarks' => '備考1',
            'impression' => '所感1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
            'impression' => null,
        ];
        $keyResult3 = [
            'id' => $this->keyResult3->id,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
            'impression' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'objective_impression' => $this->objective->impression,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result1_impression' => $keyResult1['impression'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result2_impression' => $keyResult2['impression'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
            'key_result3_impression' => $keyResult3['impression'],
        ];

        // mock set
        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult1->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult1['key_result'],
                'score' => $keyResult1['score'],
                'remarks' => $keyResult1['remarks'],
                'impression' => $keyResult1['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult1->id)
            ->andReturn($this->keyResult1);

        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult2->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult2['key_result'],
                'score' => $keyResult2['score'],
                'remarks' => $keyResult2['remarks'],
                'impression' => $keyResult2['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult2->id)
            ->andReturn($this->keyResult2);

        $this->objectiveRepo->shouldReceive('update')
            ->once()
            ->with($this->objective->user_id, [
                'user_id' => $this->objective->user_id,
                'year' => $this->objective->year,
                'quarter_id' => $this->objective->quarter_id,
                'objective' => $this->objective->objective,
                'score' => $keyResult1['score'],
                'remarks' => $this->objective->remarks,
                'impression' => $this->objective->impression,
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult3->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult3['key_result'],
                'score' => $keyResult3['score'],
                'remarks' => $keyResult3['remarks'],
                'impression' => $keyResult3['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult3->id)
            ->andReturn($this->keyResult3);

        $this->objectiveScoreHistoryRepo->shouldReceive('isTodayScoreExists')
            ->once()
            ->andReturn(false);

        $this->objectiveScoreHistoryRepo->shouldReceive('create')
            ->once()
            ->with([
                'objective_id' => $this->objective->id,
                'score' => $keyResult1['score'],
            ])
            ->andReturn($this->objectiveScoreHistory);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo,
            $this->objectiveScoreHistoryRepo
        );
        $result = $this->updateService->update($input, $this->objective->id);
        $this->assertSame($result, null);
    }

    /**
     * 成果指標 2 つの状態で 1 つ削除した場合のスコア確認
     */
    public function testTwoKeyResultsDeleteOneKeyResultPatternSuccessfully(): void
    {
        $keyResult1 = [
            'id' => $this->keyResult1->id,
            'key_result' => '成果指標1',
            'score' => 1.0,
            'remarks' => '備考1',
            'impression' => '所感1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
            'impression' => null,
        ];
        $keyResult3 = [
            'id' => null,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
            'impression' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'objective_impression' => $this->objective->impression,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result1_impression' => $keyResult1['impression'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result2_impression' => $keyResult2['impression'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
            'key_result3_impression' => $keyResult3['impression'],
        ];

        // mock set
        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult1->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult1['key_result'],
                'score' => $keyResult1['score'],
                'remarks' => $keyResult1['remarks'],
                'impression' => $keyResult1['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult1->id)
            ->andReturn($this->keyResult1);

        $this->keyResultRepo->shouldReceive('update')
            ->once()
            ->with($this->keyResult2->id, [
                'user_id' => $this->objective->user_id,
                'objective_id' => $this->objective->id,
                'key_result' => $keyResult2['key_result'],
                'score' => $keyResult2['score'],
                'remarks' => $keyResult2['remarks'],
                'impression' => $keyResult2['impression'],
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult2->id)
            ->andReturn($this->keyResult2);

        $this->objectiveRepo->shouldReceive('update')
            ->once()
            ->with($this->objective->user_id, [
                'user_id' => $this->objective->user_id,
                'year' => $this->objective->year,
                'quarter_id' => $this->objective->quarter_id,
                'objective' => $this->objective->objective,
                'score' => $keyResult1['score'],
                'remarks' => $this->objective->remarks,
                'impression' => $this->objective->impression,
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        $this->objectiveScoreHistoryRepo->shouldReceive('isTodayScoreExists')
            ->once()
            ->andReturn(false);

        $this->objectiveScoreHistoryRepo->shouldReceive('create')
            ->once()
            ->with([
                'objective_id' => $this->objective->id,
                'score' => $keyResult1['score'],
            ])
            ->andReturn($this->objectiveScoreHistory);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo,
            $this->objectiveScoreHistoryRepo
        );
        $result = $this->updateService->update($input, $this->objective->id);
        $this->assertSame($result, null);
    }
}
