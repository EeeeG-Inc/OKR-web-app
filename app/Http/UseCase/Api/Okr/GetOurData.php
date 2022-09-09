<?php
namespace App\Http\UseCase\Api\Okr;

use App\Services\Api\Okr\GetDataService;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class GetOurData
{
    /** @var UserRepositoryInterface */
    private $userRepo;

    /** @var GetDataService */
    private $GetDataService;


    public function __construct(
        UserRepositoryInterface $userRepo = null,
        GetDataService $getDataService
    ) {
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->GetDataService = $getDataService;
    }

    public function __invoke(array $input): array
    {
        $users = $this->userRepo->getByCompanyId(Auth::user()->company_id);
        $userId = is_null($input['user_id']) ? null : (int) $input['user_id'];
        $objectives = [];

        if (!is_null($userId)) {
            $user = $this->userRepo->find($userId);
            $objectives[$user->name] = $this->GetDataService->getObjectivesOfMine($user->id, $input);
            return [
                'objectives' => $objectives,
            ];
        }

        foreach ($users as $user) {
            $objectives[$user->name] = $this->GetDataService->getObjectivesOfMine($user->id, $input);
        }

        return [
            'objectives' => $objectives,
        ];
    }
}
