<?php
namespace App\Http\UseCase\Slack;

use App\Models\Slack;
use Flash;
use Illuminate\Support\Facades\Auth;

class ChangeIsActive
{
    public function __construct()
    {
    }

    public function __invoke(bool $isActive): bool
    {
        $user = Auth::user();

        Slack::where('company_id', $user->company_id)
            ->first()
            ->update([
                'is_active' => $isActive,
            ]);

        if ($isActive) {
            Flash::success(__('common/message.slack.restart'));
        } else {
            Flash::success(__('common/message.slack.stop'));
        }
        return true;
    }
}
