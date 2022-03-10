<?php
namespace App\Http\UseCase\KeyResult;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\ObjectiveRepository;
use App\Services\Slack\CommentNotificationService;
use Illuminate\Support\Facades\Auth;
use Flash;

class StoreComment
{
    /** @var CommentNotificationService */
    private $notifier;

    /** @var CommentRepositoryInterface */
    private $commentRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    public function __construct(
        CommentNotificationService $notifier,
        CommentRepositoryInterface $commentRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null
    ) {
        $this->notifier = $notifier;
        $this->commentRepo = $commentRepo ?? new CommentRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
    }

    public function __invoke(array $input): void
    {
        $user = Auth::user();
        $objectiveId = (int) $input['objective_id'];

        $this->commentRepo->create([
            'comment' => $input['comment'],
            'objective_id' => $objectiveId,
            'user_id' => $user->id,
        ]);

        $objective = $this->objectiveRepo->find($objectiveId);
        $text = $this->notifier->getTextWhenCommented($user, $objective);
        $this->notifier->send($user, $text, [
            'username' => 'Comment Bot',
            'icon_emoji' => ':pencil:',
        ]);

        Flash::success(__('common/message.key_result.comment'));
    }
}
