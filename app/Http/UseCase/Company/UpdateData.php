<?php
namespace App\Http\UseCase\Company;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    private $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo = null)
    {
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
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
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ];

            if (!is_null($input['email'])) {
                $data['email'] = $input['email'];
            }

            if (!is_null($input['password'])) {
                $data['password'] = Hash::make($input['password']);
            }

            $user->update($data);
        } catch (\Exception $exc) {
            Flash::error($exc->getMessage());
            return false;
        }

        Flash::success(__('common/message.company.update'));
        return true;
    }
}
