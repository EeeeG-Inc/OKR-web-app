<?php

namespace App\Http\UseCase\KeyResult;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\KeyResultRepository;
use App\Repositories\ObjectiveRepository;

class GetIndexData
{
    /** @var CommentRepositoryInterface */
    private $commentRepo;

    /** @var KeyResultRepositoryInterface */
    private $keyResultRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    public function __construct(
        CommentRepositoryInterface $commentRepo = null,
        KeyResultRepositoryInterface $keyResultRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null
    ) {
        $this->commentRepo = $commentRepo ?? new CommentRepository();
        $this->keyResultRepo = $keyResultRepo ?? new KeyResultRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
    }

    public function __invoke(array $input): array
    {
        $objectiveId = $input['objective_id'];
        $isArchive = $input['is_archive'] ?? null;
        $isArchive = is_null($isArchive) ? false : (bool) $isArchive;

        return [
            'comments' => $this->commentRepo->getByObjectiveId($objectiveId),
            'objective' => $this->objectiveRepo->find($objectiveId),
            'keyResults' => $this->keyResultRepo->getByObjectiveId($objectiveId),
            'isArchive' => $isArchive,
        ];
    }
}
