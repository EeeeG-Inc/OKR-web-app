<?php
namespace App\Http\UseCase\Api\Okr;

use App\Services\Api\Okr\GetDataService;
use Illuminate\Support\Facades\Auth;

class GetMineData
{
    /** @var GetDataService */
    private $GetDataService;


    public function __construct(GetDataService $getDataService)
    {
        $this->GetDataService = $getDataService;
    }

    public function __invoke(array $input): array
    {
        $user = Auth::user();
        $objectives = $this->GetDataService->getObjectivesOfMine($user->id, $input);

        return [
            'objectives' => $objectives,
        ];
    }
}
