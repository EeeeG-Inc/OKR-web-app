<?php
namespace App\Http\UseCase\KeyResult;

use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\KeyResultRepository;
use App\Repositories\ObjectiveRepository;

class GetIndexData
{
    /** @var KeyResultRepositoryInterface */
    private $keyResultRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    public function __construct(KeyResultRepositoryInterface $keyResultRepo = null, ObjectiveRepositoryInterface $objectiveRepo = null)
    {
        $this->keyResultRepo = $keyResultRepo ?? new KeyResultRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
    }

    public function __invoke(array $input): array
    {
        $objectiveId = $input['objective_id'];

        return [
            'objective' =>  $this->objectiveRepo->find($objectiveId),
            'keyResults' => $this->keyResultRepo->getByObjectiveId($objectiveId),
        ];
    }
}
