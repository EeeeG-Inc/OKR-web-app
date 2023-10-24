<?php

namespace App\Http\UseCase\KeyResult;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\CommentLikeUserRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\KeyResultRepository;
use App\Repositories\ObjectiveRepository;
use App\Repositories\CommentLikeUserRepository;

class GetIndexData
{
    /** @var CommentRepositoryInterface */
    private $commentRepo;

    /** @var KeyResultRepositoryInterface */
    private $keyResultRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    /** @var CommentLikeUserRepositoryInterface */
    private $CommentLikeUserRepo;

    public function __construct(
        CommentRepositoryInterface $commentRepo = null,
        KeyResultRepositoryInterface $keyResultRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null,
        CommentLikeUserRepositoryInterface $CommentLikeUserRepo = null
    ) {
        $this->commentRepo = $commentRepo ?? new CommentRepository();
        $this->keyResultRepo = $keyResultRepo ?? new KeyResultRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
        $this->CommentLikeUserRepo = $CommentLikeUserRepo ?? new CommentLikeUserRepository();
    }

    public function __invoke(array $input): array
    {
        $objectiveId = $input['objective_id'];
        $isArchive = $input['is_archive'] ?? null;
        $isArchive = is_null($isArchive) ? false : (bool) $isArchive;

        return [
            'comments' => $this->commentRepo->getByObjectiveId($objectiveId),
            'CommentLikeUser' => $this->CommentLikeUserRepo,
            'objective' => $this->objectiveRepo->find($objectiveId),
            'keyResults' => $this->keyResultRepo->getByObjectiveId($objectiveId),
            'isArchive' => $isArchive,
        ];
    }
}
