<?php
namespace App\Http\UseCase\Dashboard;

use App\Models\Company;
use App\Enums\Role;
use App\Services\Dashboard\UserService;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(array $input = []): array
    {
        $user = Auth::user();

        if ($user->role === Role::ADMIN) {
            $companies = Company::get()->toArray();
            return [
                'users' => $this->userService->getUsersForAdmin($input),
                'companyIdsChecks' => $this->userService->getCompanyIdsChecksforAdmin($input, $companies),
                'companies' => $companies,
            ];
        }

        $companies = Company::where('company_group_id', $user->companies->company_group_id)->get()->toArray();
        return [
            'users' => $this->userService->getUsers($user, $input),
            'companyIdsChecks' => $this->userService->getCompanyIdsChecks($input, $companies),
            'companies' => $companies,
        ];
    }
}
