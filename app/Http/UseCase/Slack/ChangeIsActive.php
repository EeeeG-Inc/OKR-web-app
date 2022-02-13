<?php
namespace App\Http\UseCase\Slack;

use App\Repositories\Interfaces\SlackRepositoryInterface;
use App\Repositories\SlackRepository;
use Flash;
use Illuminate\Support\Facades\Auth;

class ChangeIsActive
{
    /** @var SlackRepositoryInterface */
    private $slackRepo;

    public function __construct(SlackRepositoryInterface $slackRepo = null)
    {
        $this->slackRepo = $slackRepo ?? new SlackRepository();
    }

    public function __invoke(bool $isActive): bool
    {
        $user = Auth::user();

        $slack = $this->slackRepo->findByCompanyId($user->company_id);
        $this->slackRepo->update($slack->id, [
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
