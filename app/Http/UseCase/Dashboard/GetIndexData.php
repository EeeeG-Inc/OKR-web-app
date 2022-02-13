<?php
namespace App\Http\UseCase\Dashboard;

use App\Enums\Role;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Services\Dashboard\SearchService;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    /** @var SearchService */
    private $searchService;

    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    public function __construct(SearchService $searchService, CompanyRepositoryInterface $companyRepo = null)
    {
        $this->searchService = $searchService;
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
    }

    public function __invoke(array $input = []): array
    {
        $user = Auth::user();

        if ($user->role === Role::ADMIN) {
            $companies = $this->companyRepo->get()->toArray();
            return [
                'users' => $this->searchService->getUsersForAdmin($input),
                'companyIdsChecks' => $this->searchService->getCompanyIdsChecksforAdmin($input, $companies),
                'companies' => $companies,
            ];
        }

        $companies = $this->companyRepo->getByCompanyGroupId($user->companies->company_group_id)->toArray();

        return [
            'users' => $this->searchService->getUsers($user, $input),
            'companyIdsChecks' => $this->searchService->getCompanyIdsChecks($input, $companies),
            'companies' => $companies,
        ];
    }
}
