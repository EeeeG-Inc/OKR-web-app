<?php
namespace App\Http\UseCase\Objective;

use App\Enums\Quarter as Q;
use App\Models\KeyResult;
use App\Models\Objective;
use App\Models\Quarter;
use App\Services\YMD\YearService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    private $yearService;

    public function __construct(YearService $yearService)
    {
        $this->yearService = $yearService;
    }

    public function __invoke(int $objectiveId): array
    {
        $user = Auth::user();
        $companyId = $user->companies->id;
        $quarters = Quarter::where('company_id', $companyId)->orderBy('quarter', 'asc')->get();

        $objective = Objective::find($objectiveId);
        $keyResluts = KeyResult::where('objective_id', $objectiveId)->get();

        $keyResult1 = $keyResluts[0];
        $keyResult2 = $keyResluts[1] ?? null;
        $keyResult3 = $keyResluts[2] ?? null;

        // TODO: OKR Facade を作成して登録する。
        $quarterLabels = [
            __('models/quarters.full_year'),
            __('models/quarters.quarter.first_quarter') . '(' . $quarters[0]->from . '月〜' . $quarters[0]->to . '月)',
            __('models/quarters.quarter.second_quarter') . '(' . $quarters[1]->from . '月〜' . $quarters[1]->to . '月)',
            __('models/quarters.quarter.third_quarter') . '(' . $quarters[2]->from . '月〜' . $quarters[2]->to . '月)',
            __('models/quarters.quarter.fourth_quarter') . '(' . $quarters[3]->from . '月〜' . $quarters[3]->to . '月)',
        ];

        $year = $objective->year;
        $years = $this->yearService->getYearsForEdit($year);

        $quarterId = $objective->quarter_id;
        $quarterChecked = [];

        if ($quarterId === Q::FULL_YEAR_ID) {
            $quarterChecked[0] = true;
        } else {
            $quarterChecked[0] = false;
        }

        $i = 1;

        foreach ($quarters as $quarter) {
            if ($quarter->id === $quarterId) {
                $quarterChecked[$i] = true;
            } else {
                $quarterChecked[$i] = false;
            }
            $i++;
        }

        return [
            'user' => $user,
            'quarters' => $quarters,
            'quarterLabels' => $quarterLabels,
            'years' => $years,
            'objective' => $objective,
            'keyResult1' => $keyResult1,
            'keyResult2' => $keyResult2,
            'keyResult3' => $keyResult3,
            'year' => $year,
            'quarterChecked' => $quarterChecked,
        ];
    }
}
