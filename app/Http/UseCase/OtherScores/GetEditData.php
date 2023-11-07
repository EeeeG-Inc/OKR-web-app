<?php
namespace App\Http\UseCase\OtherScores;

use App\Models\Objective;
use App\Repositories\Interfaces\CanEditOtherOkrUserRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CanEditOtherOkrUserRepository;
use App\Repositories\ObjectiveRepository;
use App\Repositories\QuarterRepository;
use App\Repositories\UserRepository;
use App\Services\OKR\ScoreService;
use Illuminate\Support\Facades\Auth;

class GetEditData
{
    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    /** @var QuarterRepositoryInterface */
    private $quarterRepo;

    /** @var UserRepositoryInterface */
    private $userRepo;

    /** @var CanEditOtherOkrUserRepositoryInterface */
    private $canEditOtherOkrUserRepo;

    /** @var ScoreService */
    private $scoreService;

    public function __construct(
        ObjectiveRepositoryInterface $objectiveRepo = null,
        QuarterRepositoryInterface $quarterRepo = null,
        UserRepositoryInterface $userRepo = null,
        CanEditOtherOkrUserRepositoryInterface $canEditOtherOkrUserRepositoryInterface = null,
        ScoreService $scoreService
    ) {
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->canEditOtherOkrUserRepo = $canEditOtherOkrUserRepositoryInterface ?? new CanEditOtherOkrUserRepository();
        $this->scoreService = $scoreService;
    }

    public function __invoke(int $userId): array
    {
        $loginUser = $this->userRepo->find($userId);

        // 編集できる対象を取得
        $canEditOtherOkrUserIds = $this->canEditOtherOkrUserRepo->getTargetUserIdsByCanEdit($loginUser->id);

        // 現在対応中の四半期情報
        $quarterData = $this->quarterRepo->getYearAndQuarterAtToday($loginUser->company->id);
        $datum = [];

        foreach ($canEditOtherOkrUserIds as $index => $canEditOtherOkrUserId) {
            $objectives = $this->objectiveRepo->getByUserIdAndYearAndQuarterId($canEditOtherOkrUserId, $quarterData['year'], $quarterData['quarter_id']);

            if ($objectives->isEmpty()) {
                continue;
            }

            $datum[$index]['objectives'] = $objectives;
            $datum[$index]['user'] = $this->userRepo->find($canEditOtherOkrUserId);
        }

        return [
            'user' => $loginUser,
            'datum' => $datum,
            'scores' => $this->scoreService->getScores(),
        ];
    }
}
