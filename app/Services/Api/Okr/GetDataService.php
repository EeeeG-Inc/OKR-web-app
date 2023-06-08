<?php

namespace App\Services\Api\Okr;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\ObjectiveRepository;
use App\Repositories\QuarterRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class GetDataService
{
    /** @var CommentRepositoryInterface */
    private $commentRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    /** @var QuarterRepositoryInterface */
    private $quarterRepo;

    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(
        CommentRepositoryInterface $commentRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null,
        QuarterRepositoryInterface $quarterRepo = null,
        UserRepositoryInterface $userRepo = null
    ) {
        $this->commentRepo = $commentRepo ?? new CommentRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function getObjectives(int $userId, array $input): Collection
    {
        $year = is_null($input['year']) ? null : (int) $input['year'];
        $quarterId = is_null($input['quarter_id']) ? null : (int) $input['quarter_id'];

        if (is_null($year) && is_null($quarterId)) {
            $user = $this->userRepo->find($userId);
            [
                'year' => $year,
                'quarter_id' => $quarterId,
            ] = $this->quarterRepo->getYearAndQuarterAtToday($user->company->id);
        }

        $objectives = $this->objectiveRepo->getByUserIdAndYearAndQuarterId(
            $userId,
            $year,
            $quarterId,
            is_null($input['is_archived']) ? false : (bool) $input['is_archived'],
            is_null($input['is_include_full_year']) ? false : (bool) $input['is_include_full_year']
        );

        foreach ($objectives as $key => $objective) {
            $objectives[$key]['key_results'] = $objective->keyResults;
            $objectives[$key]['quarter'] = $objective->quarter;
            $objectives[$key]['comments'] = $this->commentRepo->getByObjectiveId($objective->id);
        }

        return $objectives;
    }
}
