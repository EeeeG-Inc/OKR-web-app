<?php
namespace App\Http\UseCase\Slack;

use App\Repositories\Interfaces\SlackRepositoryInterface;
use App\Repositories\SlackRepository;
use Flash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    /** @var SlackRepositoryInterface */
    private $slackRepo;

    public function __construct(SlackRepositoryInterface $slackRepo = null)
    {
        $this->slackRepo = $slackRepo ?? new SlackRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        $this->slackRepo->create([
            'webhook' => $input['webhook'],
            'company_id' => $user->company_id,
            'is_active' => true,
        ]);

        Flash::success(__('common/message.slack.store'));
        return true;
    }
}
