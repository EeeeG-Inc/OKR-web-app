<?php
namespace App\Http\UseCase\Objective;

use App\Enums\Priority;
use App\Repositories\Interfaces\KeyResultRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\KeyResultRepository;
use App\Repositories\ObjectiveRepository;
use App\Repositories\QuarterRepository;
use App\Services\OKR\ScoreService;
use App\Services\YMD\YearService;
use App\Services\Quarter\ControlFieldsService;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    /** @var YearService */
    private $yearService;

    /** @var ControlFieldsService */
    private $controlFieldsService;

    /** @var ScoreService */
    private $scoreService;

    /** @var KeyResultRepositoryInterface */
    private $keyResultRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    /** @var QuarterRepositoryInterface */
    private $quarterRepo;

    public function __construct(
        YearService $yearService,
        ControlFieldsService $controlFieldsService,
        ScoreService $scoreService,
        KeyResultRepositoryInterface $keyResultRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null,
        QuarterRepositoryInterface $quarterRepo = null
    ) {
        $this->yearService = $yearService;
        $this->controlFieldsService = $controlFieldsService;
        $this->scoreService = $scoreService;
        $this->keyResultRepo = $keyResultRepo ?? new KeyResultRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
    }

    public function __invoke(int $objectiveId): array
    {
        $user = Auth::user();
        $quarters = $this->quarterRepo->getByCompanyId($user->company->id);
        $objective = $this->objectiveRepo->find($objectiveId);
        $keyResluts = $this->keyResultRepo->getByObjectiveId($objectiveId);
        $year = $objective->year;

        return [
            'user' => $user,
            'quarters' => $quarters,
            'quarterLabels' => $this->controlFieldsService->getQuarterLabels($quarters),
            'year' => $year,
            'years' => $this->yearService->getYearsForEdit($year),
            'scores' => $this->scoreService->getScores(),
            'objective' => $objective,
            'priority' => $objective->priority,
            'prioritys' => Priority::getFlipLocalizedDescription(),
            'keyResult1' => $keyResluts[0],
            'keyResult2' => $keyResluts[1] ?? null,
            'keyResult3' => $keyResluts[2] ?? null,
            'quarterChecked' => $this->controlFieldsService->getQuarterChecked($objective, $quarters),
        ];
    }
}
