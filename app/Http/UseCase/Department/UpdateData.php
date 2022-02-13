<?php
namespace App\Http\UseCase\Department;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\DepartmentRepository;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateData
{
    private $departmentRepo;

    public function __construct(DepartmentRepositoryInterface $departmentRepo = null)
    {
        $this->departmentRepo = $departmentRepo ?? new DepartmentRepository();
    }

    public function __invoke(array $input): bool
    {
        $user = Auth::user();

        try {
            $department = $this->departmentRepo->find($user->department_id);
            $this->departmentRepo->update($department->id, [
                'name' => $input['name'],
            ]);

            $data = [
                'name' => $input['name'],
                'role' => $input['role'],
                'company_id' => $input['company_id'] ?? $user->company_id,
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

        Flash::success(__('common/message.department.update'));
        return true;
    }
}
