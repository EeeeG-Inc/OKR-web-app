<?php
namespace App\Http\UseCase\Quarter;

use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\QuarterRepository;
use Flash;

class UpdateData
{
    /** @var QuarterRepositoryInterface */
    private $quarterRepo;

    public function __construct(QuarterRepositoryInterface $quarterRepo = null)
    {
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
    }

    public function __invoke(array $input, int $companyId): bool
    {
        $i = 1;
        while ($i < 5) {
            $quarter = $this->quarterRepo->findByQuarterAndCompanyId($i, $companyId);
            $quarter = $this->quarterRepo->update($quarter->id, [
                'from' => $input[$i . 'q_from'],
                'to' => $input[$i . 'q_to'],
            ]);
            $i++;
        }

        Flash::success(__('common/message.quarter.update'));
        return true;
    }
}
