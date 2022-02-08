<?php
namespace App\Http\UseCase\Quarter;

use App\Models\Quarter;
use Flash;

class UpdateData
{
    public function __construct()
    {
    }

    public function __invoke(array $input, int $companyId): bool
    {
        $i = 1;
        while ($i < 5) {
            Quarter::where('company_id', $companyId)
                ->where('quarter', $i)
                ->first()
                ->update([
                    'from' => $input[$i . 'q_from'],
                    'to' => $input[$i . 'q_to'],
                ]);
            $i++;
        }

        Flash::success(__('common/message.quarter.update'));
        return true;
    }
}
