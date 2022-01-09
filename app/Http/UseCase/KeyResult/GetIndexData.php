<?php
namespace App\Http\UseCase\KeyResult;

use App\Models\Objective;
use App\Models\KeyResult;

class GetIndexData
{
    public function __construct()
    {
    }

    public function __invoke(array $input): array
    {
        $objectiveId = $input['objective_id'];

        return [
            'objective' =>  Objective::find($objectiveId),
            'keyResults' => KeyResult::where('objective_id', $objectiveId)->get(),
        ];
    }
}
