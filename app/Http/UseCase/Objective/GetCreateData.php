<?php

namespace App\Http\UseCase\Objective;

use App\Enums\Priority;
use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\QuarterRepository;
use App\Services\Quarter\ControlFieldsService;
use App\Services\YMD\YearService;
use Illuminate\Support\Facades\Auth;

class GetCreateData
{
    /** @var ControlFieldsService */
    private $controlFieldsService;

    /** @var YearService */
    private $yearService;

    /** @var QuarterRepositoryInterface */
    private $quarterRepo;

    public function __construct(
        YearService $yearService,
        ControlFieldsService $controlFieldsService,
        QuarterRepositoryInterface $quarterRepo = null
    ) {
        $this->yearService = $yearService;
        $this->controlFieldsService = $controlFieldsService;
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $quarters = $this->quarterRepo->getByCompanyId($user->company->id);
        [
            'year' => $thisYear,
            'quarter_id' => $thisQuarterId,
        ] = $this->quarterRepo->getYearAndQuarterAtToday($user->company->id);

        return [
            'user' => $user,
            'quarters' => $quarters,
            'quarterLabels' => $this->controlFieldsService->getQuarterLabels($quarters),
            'years' => $this->yearService->getYearsForCreate(),
            'prioritys' => Priority::getFlipLocalizedDescription(),
            'thisYear' => $thisYear,
            'thisQuarterId' => $thisQuarterId,
        ];
    }
}
