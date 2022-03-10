<?php
namespace App\Http\UseCase\KeyResult;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\ObjectiveRepository;
use App\Services\Slack\CommentNotificationService;
use Illuminate\Support\Facades\Auth;
use Flash;

class DestroyComment
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

    public function __invoke(int $commentId, int $objectiveId): bool
    {
        $user = Auth::user();
        $comment = $this->commentRepo->find($commentId);
        $objective = $this->objectiveRepo->find($objectiveId);

        if ($this->commentRepo->delete($comment)) {
            $text = $this->notifier->getTextWhenDeleted($user, $objective);
            $this->notifier->send($user, $text, [
                'username' => 'Comment Bot',
                'icon_emoji' => ':pencil:',
            ]);
            Flash::success(__('common/message.key_result.delete_comment_success'));
            return true;
        }

        Flash::error(__('common/message.key_result.delete_comment_failed'));
        return false;
    }
}
