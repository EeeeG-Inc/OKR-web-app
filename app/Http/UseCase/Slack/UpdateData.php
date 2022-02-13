<?php
namespace App\Http\UseCase\Slack;

use App\Repositories\Interfaces\SlackRepositoryInterface;
use App\Repositories\SlackRepository;
use Flash;

class UpdateData
{
    private $slackRepo;

    public function __construct(SlackRepositoryInterface $slackRepo = null)
    {
        $this->slackRepo = $slackRepo ?? new SlackRepository();
    }

    public function __invoke(array $input, int $companyId): bool
    {
        $slack = $this->slackRepo->findByCompanyId($companyId);
        $this->slackRepo->update($slack->id, [
            'webhook' => $input['webhook'],
        ]);

        Flash::success(__('common/message.slack.update'));
        return true;
    }
}
