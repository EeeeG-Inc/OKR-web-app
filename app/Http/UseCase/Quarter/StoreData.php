<?php
namespace App\Http\UseCase\Quarter;

use App\Models\Quarter;
use Flash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    public function __construct()
    {
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        $i = 1;
        while ($i < 5) {
            Quarter::create([
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
