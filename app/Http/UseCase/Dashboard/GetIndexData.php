<?php
namespace App\Http\UseCase\Dashboard;

use App\Models\Company;
use App\Enums\Role;
use App\Services\Dashboard\SearchService;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    /** @var SearchService */
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function __invoke(array $input = []): array
    {
        $user = Auth::user();

        if ($user->role === Role::ADMIN) {
            $companies = Company::get()->toArray();
            return [
                'users' => $this->searchService->getUsersForAdmin($input),
                'companyIdsChecks' => $this->searchService->getCompanyIdsChecksforAdmin($input, $companies),
                'companies' => $companies,
            ];
        }

        $companies = Company::where('company_group_id', $user->companies->company_group_id)->get()->toArray();
        return [
            'users' => $this->searchService->getUsers($user, $input),
            'companyIdsChecks' => $this->searchService->getCompanyIdsChecks($input, $companies),
            'companies' => $companies,
        ];
    }
}
