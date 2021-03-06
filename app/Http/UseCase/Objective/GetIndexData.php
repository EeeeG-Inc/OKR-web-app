<?php
namespace App\Http\UseCase\Objective;

use App\Services\OKR\SearchService;

class GetIndexData
{
    /** @var SearchService */
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function __invoke(array $input, bool $isArchived = false): array
    {
        $userInfo = $this->searchService->getUserInfo($input);
        $user = $userInfo['user'];
        $relativeUsers = $this->searchService->getRelativeUsers($user);

        return [
            'user' => $user,
            'objectives' => $this->searchService->getObjectives($input, $user->id, $isArchived),
            'isLoginUser' => $userInfo['is_login_user'],
            'quarterExists' => $this->searchService->isQuarterExists($user->company_id),
            'companyUser' => $relativeUsers['company_user'],
            'departmentUser' => $relativeUsers['department_user'],
            'years' => $this->searchService->getYears($user->id),
        ];
    }
}
