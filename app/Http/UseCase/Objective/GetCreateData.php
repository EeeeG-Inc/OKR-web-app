<?php
namespace App\Http\UseCase\Objective;

use App\Models\Quarter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetCreateData
{
    public function __construct()
    {
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
        $years = $this->getYearsForCreate();

        return [
            'user' => $user,
            'quarters' => $quarters,
            'quarterLabels' => $quarterLabels,
            'years' => $years,
        ];
    }

    private function getYearsForCreate(): array
    {
        $prevYear = Carbon::now()->subYear()->format('Y');
        $year = Carbon::now()->format('Y');
        $nextYear = Carbon::now()->addYear()->format('Y');

        return [
            $prevYear => $prevYear,
            $year => $year,
            $nextYear => $nextYear,
        ];
    }
}
