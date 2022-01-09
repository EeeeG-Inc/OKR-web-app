<?php
namespace App\Http\UseCase\Objective;

use App\Models\KeyResult;
use App\Models\Objective;
use DB;
use Flash;

class DestroyData
{
    public function __construct()
    {
    }

    public function __invoke(int $objectiveId): bool
    {
        $objective = Objective::find($objectiveId);
        $objectiveName = Objective::find($objectiveId)->objective;

        DB::beginTransaction();

        try {
            KeyResult::where('objective_id', $objectiveId)->delete();
            $objective->delete();
        } catch (\Exception $exc) {
            Flash::error(__('common/message.objective.delete_failed', ['objective' => $objectiveName]));
            DB::rollBack();
            return false;
        }

        DB::commit();

        Flash::success(__('common/message.objective.delete_success', ['objective' => $objectiveName]));
        return true;
    }
}
