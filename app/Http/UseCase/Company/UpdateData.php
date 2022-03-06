<?php
namespace App\Http\UseCase\Company;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Services\User\UpdateService;
use Flash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    /** @var UpdateService */
    private $updateService;

    /** @var CompanyRepositoryInterface */
    private $companyRepo;


    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(
        UpdateService $updateService,
        CompanyRepositoryInterface $companyRepo = null,
        UserRepositoryInterface $userRepo = null
    ) {
        $this->updateService = $updateService;
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $this->companyRepo->find($user->company_id)->update([
                'name' => $input['name'],
            ]);

            $data = [
                'name' => $input['name'],
                'role' => $input['role'],
            ];

            $data = $this->updateService->appendNullableAttribute($input, $data, $user);
            $this->userRepo->update($user->id, $data);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.company.update'));
        return true;
    }
}
