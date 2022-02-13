<?php
namespace App\Http\UseCase\Company;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    private $userRepo;
    private $companyRepo;

    public function __construct(UserRepositoryInterface $userRepo = null, CompanyRepositoryInterface $companyRepo = null)
    {
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $companyId = $this->companyRepo->create([
                'name' => $input['name'],
                'is_master' => false,
                'company_group_id' => $user->companies->company_group_id,
            ])->id;

            $this->userRepo->create([
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $companyId,
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.company.store'));
        return true;
    }
}
