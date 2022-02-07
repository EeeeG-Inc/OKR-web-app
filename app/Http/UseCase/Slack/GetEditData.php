<?php
namespace App\Http\UseCase\Slack;

use App\Models\Slack;

class GetEditData
{
    public function __construct()
    {
    }

    public function __invoke(int $companyId): array
    {
        $slack = Slack::where('company_id', $companyId)->first();

        return [
            'webhook' => $slack->webhook ?? null,
            'companyId' => $companyId,
        ];
    }
}
