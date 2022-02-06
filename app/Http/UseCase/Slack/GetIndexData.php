<?php
namespace App\Http\UseCase\Slack;

use App\Models\Slack;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    public function __construct()
    {
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $slack = Slack::where('company_id', $companyId)->first();
        $canCreate = false;

        if (is_null($slack)) {
            $canCreate = true;
            Flash::warning(__('validation.not_found_slack_webhook'));
        }

        return [
            'slack' => $slack,
            'canCreate' => $canCreate,
            'isActive' => $slack->is_active ?? null,
            'companyId' => $companyId,
        ];
    }
}
