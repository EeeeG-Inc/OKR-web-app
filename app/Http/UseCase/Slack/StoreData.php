<?php
namespace App\Http\UseCase\Slack;

use App\Models\Slack;
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

        Slack::create([
            'webhook' => $input['webhook'],
            'company_id' => $user->company_id,
            'is_active' => true,
        ]);

        Flash::success(__('common/message.slack.store'));
        return true;
    }
}
