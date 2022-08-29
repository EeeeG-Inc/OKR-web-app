<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\OKR\UpdateService;
use App\Models\KeyResult;
use App\Models\Objective;
use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
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

    public function setUp(): void
    {
        parent::setUp();
        CarbonImmutable::setTestNow(CarbonImmutable::now());
        /** @var KeyResultRepositoryInterface  */
        $this->keyResultRepo = m::mock(KeyResultRepositoryInterface::class);
        /** @var ObjectiveRepositoryInterface  */
        $this->objectiveRepo = m::mock(ObjectiveRepositoryInterface::class);

        // model の mock
        $this->keyResult1 = m::mock(KeyResult::class);
        $this->keyResult2 = m::mock(KeyResult::class);
        $this->keyResult3 = m::mock(KeyResult::class);
        $this->objective = m::mock(Objective::class);

        $this->keyResult1->allows('getAttribute')->with('id')->andReturn(1);
        $this->keyResult1->allows('offsetExists')->andReturn(true);

        $this->keyResult2->allows('getAttribute')->with('id')->andReturn(2);
        $this->keyResult2->allows('offsetExists')->andReturn(true);

        $this->keyResult3->allows('getAttribute')->with('id')->andReturn(3);
        $this->keyResult3->allows('offsetExists')->andReturn(true);

        $this->objective->allows('getAttribute')->with('id')->andReturn(1);
        $this->objective->allows('getAttribute')->with('objective')->andReturn('テスト目標');
        $this->objective->allows('getAttribute')->with('remarks')->andReturn('テスト備考');
        $this->objective->allows('getAttribute')->with('priority')->andReturn(1);
        $this->objective->allows('getAttribute')->with('quarter_id')->andReturn(1);
        $this->objective->allows('getAttribute')->with('user_id')->andReturn(1);
        $this->objective->allows('getAttribute')->with('year')->andReturn(2022);
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
        ];
        $keyResult2 = [
            'id' => null,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
        ];
        $keyResult3 = [
            'id' => null,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
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
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo
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
            'remarks' => 'テスト1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => '成果指標2',
            'score' => '0.5',
            'remarks' => 'テスト2',
        ];
        $keyResult3 = [
            'id' => null,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
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
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo
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
            'remarks' => 'テスト1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => '成果指標2',
            'score' => '0.5',
            'remarks' => 'テスト2',
        ];
        $keyResult3 = [
            'id' => $this->keyResult3->id,
            'key_result' => '成果指標3',
            'score' => '0.5',
            'remarks' => 'テスト3',
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
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
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo
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
            'remarks' => 'テスト1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => '成果指標2',
            'score' => 1.0,
            'remarks' => 'テスト2',
        ];
        $keyResult3 = [
            'id' => $this->keyResult3->id,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
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
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult3->id)
            ->andReturn($this->keyResult3);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo
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
            'remarks' => 'テスト1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
        ];
        $keyResult3 = [
            'id' => $this->keyResult3->id,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
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
            ])
            ->andReturn(true);
        $this->keyResultRepo->shouldReceive('find')
            ->once()
            ->with($this->keyResult3->id)
            ->andReturn($this->keyResult3);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo
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
            'remarks' => 'テスト1',
        ];
        $keyResult2 = [
            'id' => $this->keyResult2->id,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
        ];
        $keyResult3 = [
            'id' => null,
            'key_result' => null,
            'score' => '0',
            'remarks' => null,
        ];
        $input = [
            'user_id' => $this->objective->user_id,
            'year' => $this->objective->year,
            'quarter_id' => $this->objective->quarter_id,
            'objective' => $this->objective->objective,
            'objective_remarks' => $this->objective->remarks,
            'priority' => $this->objective->priority,
            'key_result1_id' => $keyResult1['id'],
            'key_result1' => $keyResult1['key_result'],
            'key_result1_score' => $keyResult1['score'],
            'key_result1_remarks' => $keyResult1['remarks'],
            'key_result2_id' => $keyResult2['id'],
            'key_result2' => $keyResult2['key_result'],
            'key_result2_score' => $keyResult2['score'],
            'key_result2_remarks' => $keyResult2['remarks'],
            'key_result3_id' => $keyResult3['id'],
            'key_result3' => $keyResult3['key_result'],
            'key_result3_score' => $keyResult3['score'],
            'key_result3_remarks' => $keyResult3['remarks'],
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
                'priority' => $this->objective->priority,
            ])
            ->andReturn(true);

        // Target
        $this->updateService = new UpdateService(
            $this->keyResultRepo,
            $this->objectiveRepo
        );
        $result = $this->updateService->update($input, $this->objective->id);
        $this->assertSame($result, null);
    }
}
