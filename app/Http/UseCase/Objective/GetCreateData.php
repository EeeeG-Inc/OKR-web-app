<?php
namespace App\Http\UseCase\Objective;

use App\Models\Quarter;
use App\Services\YMD\YearService;
use Illuminate\Support\Facades\Auth;

class GetCreateData
{
    private $yearService;

    public function __construct(YearService $yearService)
    {
        $this->yearService = $yearService;
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->companies->id;
        $quarters = Quarter::where('company_id', $companyId)->orderBy('quarter', 'asc')->get();

        $quarterLabels = [
            __('models/quarters.full_year'),
            __('models/quarters.quarter.first_quarter') . '(' . $quarters[0]->from . '月〜' . $quarters[0]->to . '月)',
            __('models/quarters.quarter.second_quarter') . '(' . $quarters[1]->from . '月〜' . $quarters[1]->to . '月)',
            __('models/quarters.quarter.third_quarter') . '(' . $quarters[2]->from . '月〜' . $quarters[2]->to . '月)',
            __('models/quarters.quarter.fourth_quarter') . '(' . $quarters[3]->from . '月〜' . $quarters[3]->to . '月)',
        ];
        $years = $this->yearService->getYearsForCreate();

        return [
            'user' => $user,
            'quarters' => $quarters,
            'quarterLabels' => $quarterLabels,
            'years' => $years,
        ];
    }
}
