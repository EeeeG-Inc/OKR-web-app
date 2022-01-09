<?php
namespace App\Http\UseCase\Quarter;

use App\Models\Quarter;
use App\Services\YMD\MonthService;

class GetEditData
{
    private $monthService;

    public function __construct(MonthService $monthService)
    {
        $this->monthService = $monthService;
    }

    public function __invoke(int $companyId): array
    {
        $quarters = [];
        $i = 1;
        while ($i < 5) {
            $quarters[] = Quarter::where('company_id', $companyId)
            ->where('quarter', $i)
            ->first();
            $i++;
        }

        return [
            'companyId' => $companyId,
            'firstQuarter' => $quarters[0],
            'secondQuarter' => $quarters[1],
            'thirdQuarter' => $quarters[2],
            'fourthQuarter' => $quarters[3],
            'from' => $this->monthService->createMonthsArray(),
        ];
    }
}
