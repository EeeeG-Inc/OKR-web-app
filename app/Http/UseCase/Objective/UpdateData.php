<?php
namespace App\Http\UseCase\Objective;

use App\Services\OKR\UpdateService;
use Flash;

class UpdateData
{
    private $updateService;

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;
    }

    public function __invoke(array $input, int $objectiveId): bool
    {
        try {
            $this->updateService->update($input, $objectiveId);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.objective.update'));
        return true;
    }
}
