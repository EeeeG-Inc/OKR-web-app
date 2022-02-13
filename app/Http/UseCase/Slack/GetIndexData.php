<?php
namespace App\Http\UseCase\Slack;

use App\Repositories\Interfaces\SlackRepositoryInterface;
use App\Repositories\SlackRepository;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    private $slackRepo;

    public function __construct(SlackRepositoryInterface $slackRepo = null)
    {
        $this->slackRepo = $slackRepo ?? new SlackRepository();
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $slack = $this->slackRepo->findByCompanyId($companyId);
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
