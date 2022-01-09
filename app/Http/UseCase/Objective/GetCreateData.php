<?php
namespace App\Http\UseCase\Objective;

use App\Models\Quarter;
use App\Services\Quarter\LabelService;
use App\Services\YMD\YearService;
use Illuminate\Support\Facades\Auth;

class GetCreateData
{
    private $labelService;
    private $yearService;

    public function __construct(YearService $yearService, LabelService $labelService)
    {
        $this->yearService = $yearService;
        $this->labelService = $labelService;
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $quarters = Quarter::where('company_id', $user->companies->id)->orderBy('quarter', 'asc')->get();

        return [
            'user' => $user,
            'quarters' => $quarters,
            'quarterLabels' => $this->labelService->getQuarterLabels($quarters),
            'years' => $this->yearService->getYearsForCreate(),
        ];
    }
}
