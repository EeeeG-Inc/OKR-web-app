<?php
namespace App\Http\UseCase\Quarter;

use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\QuarterRepository;
use Flash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    private $quarterRepo;

    public function __construct(QuarterRepositoryInterface $quarterRepo = null)
    {
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        $i = 1;
        while ($i < 5) {
            $this->quarterRepo->create([
                'quarter' => $i,
                'from' => $input[$i . 'q_from'],
                'to' => $input[$i . 'q_to'],
                'company_id' => $user->company_id,
            ]);
            $i++;
        }

        Flash::success(__('common/message.quarter.store'));
        return true;
    }
}
