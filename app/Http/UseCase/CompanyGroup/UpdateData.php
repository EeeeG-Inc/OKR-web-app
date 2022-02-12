<?php

namespace App\Http\UseCase\CompanyGroup;

use App\Services\CompanyGroup\UpdateService;
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
            $this->updateService->update($input);
        } catch (\Exception $exc) {
            Flash::error(__('common/message.company_group.update_failed'));
            return false;
        }

        Flash::success(__('common/message.company_group.update_success'));
        return true;
    }
}
