<?php
namespace App\Http\UseCase\Quarter;

use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\QuarterRepository;
use App\Services\YMD\MonthService;

class GetEditData
{
    private $monthService;
    private $quarterRepo;

    public function __construct(MonthService $monthService, QuarterRepositoryInterface $quarterRepo = null)
    {
        $this->monthService = $monthService;
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
    }

    public function __invoke(int $companyId): array
    {
        $quarters = [];
        $i = 1;
        while ($i < 5) {
            $quarters[] = $this->quarterRepo->findByQuarterAndCompanyId($i, $companyId);
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
