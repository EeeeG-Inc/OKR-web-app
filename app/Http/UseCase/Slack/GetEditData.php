<?php
namespace App\Http\UseCase\Slack;

use App\Repositories\Interfaces\SlackRepositoryInterface;
use App\Repositories\SlackRepository;

class GetEditData
{
    private $slackRepo;

    public function __construct(SlackRepositoryInterface $slackRepo = null)
    {
        $this->slackRepo = $slackRepo ?? new SlackRepository();
    }

    public function __invoke(int $companyId): array
    {
        $slack = $this->slackRepo->findByCompanyId($companyId);

        return [
            'webhook' => $slack->webhook ?? null,
            'companyId' => $companyId,
        ];
    }
}
