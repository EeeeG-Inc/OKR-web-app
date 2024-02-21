<?php
namespace App\Http\UseCase\OtherScores;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\ObjectiveRepository;
use App\Repositories\UserRepository;
use App\Services\OtherScores\UpdateService;
use App\Services\Slack\CommentNotificationService;
use DB;
use Flash;

class UpdateData
{
    /** @var UpdateService */
    private $updateService;

    /** @var CommentNotificationService */
    private $notifier;

    /** @var CommentRepositoryInterface */
    private $commentRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(
        UpdateService $updateService,
        CommentNotificationService $notifier,
        CommentRepositoryInterface $commentRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null,
        UserRepositoryInterface $userRepo = null
    ) {
        $this->updateService = $updateService;
        $this->notifier = $notifier;
        $this->commentRepo = $commentRepo ?? new CommentRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function __invoke(array $input, int $userId): bool
    {
        DB::beginTransaction();

        try {
            foreach ($input['key_result1_score'] as $objectiveId => $keyResult1) {
                $keyResult2 = $input['key_result2_score'][$objectiveId] ?? null;
                $keyResult3 = $input['key_result3_score'][$objectiveId] ?? null;
                $comment = $input['comment'][$objectiveId] ?? null;

                // OKR 更新
                $this->updateService->update([
                    'key_result1_id' => key($keyResult1),
                    'key_result2_id' => is_null($keyResult2) ? null : key($keyResult2),
                    'key_result3_id' => is_null($keyResult3) ? null : key($keyResult3),
                    'key_result1_score' => reset($keyResult1),
                    'key_result2_score' => is_null($keyResult2) ? null : reset($keyResult2),
                    'key_result3_score' => is_null($keyResult3) ? null : reset($keyResult3),
                ], $objectiveId);

                // コメントがあれば登録
                if (!empty($comment)) {
                    $user = $this->userRepo->find($userId);
                    $this->commentRepo->create([
                        'comment' => $comment,
                        'objective_id' => $objectiveId,
                        'user_id' => $user->id,
                    ]);
                    $objective = $this->objectiveRepo->find($objectiveId);
                    $text = $this->notifier->getTextWhenCommented($user, $objective);
                    $this->notifier->send($user, $text, [
                        'username' => 'Comment Bot',
                        'icon_emoji' => ':pencil:',
                    ]);
                }
            }
        } catch (\Exception $e) {
            Flash::error(__('common/message.other_okr.failed'));
            DB::rollBack();
            return false;
        }


        DB::commit();
        Flash::success(__('common/message.other_scores.update'));
        return true;
    }
}
