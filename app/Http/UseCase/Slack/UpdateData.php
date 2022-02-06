<?php
namespace App\Http\UseCase\Slack;

use App\Models\Slack;
use Flash;

class UpdateData
{
    public function __construct()
    {
    }

    public function __invoke(array $input, int $companyId): bool
    {
        Slack::where('company_id', $companyId)->first()->update([
            'webhook' => $input['webhook'],
        ]);

        Flash::success(__('common/message.slack.update'));
        return true;
    }
}
