<?php
namespace App\Http\UseCase\Api\Quarter;

use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\QuarterRepository;
use Illuminate\Support\Facades\Auth;

class GetData
{
    /** @var QuarterRepositoryInterface */
    private $quarterRepo;

    public function __construct(QuarterRepositoryInterface $quarterRepo = null)
    {
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
    }

    public function __invoke(): array
    {
        $result = [];

        $result['FULL_YEAR'] = $this->quarterRepo->findQuarterFullYear();
        $quarters = $this->quarterRepo->getByCompanyId(Auth::user()->company_id);

        foreach ($quarters as $quarter) {
            $result[$quarter->quarter . 'Q'] = $quarter;
        }

        return [
            'quarters' => $result,
        ];
    }
}
