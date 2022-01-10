<?php
namespace App\Http\UseCase\Objective;

use App\Models\Quarter;
use App\Services\Quarter\ControlFieldsService;
use App\Services\YMD\YearService;
use Illuminate\Support\Facades\Auth;

class GetCreateData
{
    private $controlFieldsService;
    private $yearService;

    public function __construct(YearService $yearService, ControlFieldsService $controlFieldsService)
    {
        $this->yearService = $yearService;
        $this->controlFieldsService = $controlFieldsService;
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $quarters = Quarter::where('company_id', $user->companies->id)->orderBy('quarter', 'asc')->get();

        return [
            'user' => $user,
            'quarters' => $quarters,
            'quarterLabels' => $this->controlFieldsService->getQuarterLabels($quarters),
            'years' => $this->yearService->getYearsForCreate(),
        ];
    }
}
