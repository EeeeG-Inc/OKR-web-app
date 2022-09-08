<?php

namespace App\Services\Api\Okr;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\ObjectiveRepository;
use Illuminate\Database\Eloquent\Collection;

class GetDataService
{

    /** @var CommentRepositoryInterface */
    private $commentRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    public function __construct(
        CommentRepositoryInterface $commentRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null
    ) {
        $this->commentRepo = $commentRepo ?? new CommentRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
    }

    public function getObjectivesOfMine(int $userId, array $input): Collection
    {
        if (is_null($input['is_archived'])) {
            $objectives = $this->objectiveRepo->getByUserIdAndYearAndQuarterId(
                $userId,
                (int) $input['year'],
                (int) $input['quarter_id'],
                null
            );
        } else {
            $objectives = $this->objectiveRepo->getByUserIdAndYearAndQuarterId(
                $userId,
                (int) $input['year'],
                (int) $input['quarter_id'],
                (bool) $input['is_archived']
            );
        }

        foreach ($objectives as $key => $objective) {
            $objectives[$key]['key_results'] = $objective->keyResults;
            $objectives[$key]['quarter'] = $objective->quarter;
            $objectives[$key]['comments'] = $this->commentRepo->getByObjectiveId($objective->id);
        }

        return $objectives;
    }
}
