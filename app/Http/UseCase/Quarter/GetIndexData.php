<?php
namespace App\Http\UseCase\Quarter;

use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\QuarterRepository;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    private $quarterRepo;

    public function __construct(QuarterRepositoryInterface $quarterRepo = null)
    {
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $quarters = $this->quarterRepo->getByCompanyId($companyId);
        $canCreate = false;

        if ($quarters->isEmpty()) {
            $canCreate = true;
            Flash::error(__('validation.not_found_quarter'));
        }

        return [
            'quarters' => $quarters,
            'canCreate' => $canCreate,
            'companyId' => $companyId,
        ];
    }
}
