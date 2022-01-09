<?php
namespace App\Http\UseCase\Objective;

use App\Models\KeyResult;
use App\Models\Objective;
use App\Models\Quarter;
use App\Services\YMD\YearService;
use App\Services\Quarter\LabelService;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    private $yearService;
    private $labelService;

    public function __construct(YearService $yearService, LabelService $labelService)
    {
        $this->yearService = $yearService;
        $this->labelService = $labelService;
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
            'quarterLabels' => $this->labelService->getQuarterLabels($quarters),
            'year' => $year,
            'years' => $this->yearService->getYearsForEdit($year),
            'objective' => $objective,
            'keyResult1' => $keyResluts[0],
            'keyResult2' => $keyResluts[1] ?? null,
            'keyResult3' => $keyResluts[2] ?? null,
            'quarterChecked' => $this->labelService->getQuarterChecked($objective, $quarters),
        ];
    }
}
