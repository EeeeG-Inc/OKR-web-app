<?php
namespace App\Http\UseCase\Objective;

use App\Enums\Priority;
use App\Models\KeyResult;
use App\Models\Objective;
use App\Models\Quarter;
use App\Services\OKR\ScoreService;
use App\Services\YMD\YearService;
use App\Services\Quarter\ControlFieldsService;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    private $yearService;
    private $controlFieldsService;
    private $scoreService;

    public function __construct(YearService $yearService, ControlFieldsService $controlFieldsService, ScoreService $scoreService)
    {
        $this->yearService = $yearService;
        $this->controlFieldsService = $controlFieldsService;
        $this->scoreService = $scoreService;
    }

    public function __invoke(int $objectiveId): array
    {
        $user = Auth::user();
        $quarters = Quarter::where('company_id', $user->companies->id)->orderBy('quarter', 'asc')->get();
        $objective = Objective::find($objectiveId);
        $keyResluts = KeyResult::where('objective_id', $objectiveId)->get();
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
