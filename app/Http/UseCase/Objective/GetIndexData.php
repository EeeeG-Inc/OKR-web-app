<?php
namespace App\Http\UseCase\Objective;

use App\Models\Objective;
use App\Models\User;
use App\Models\Quarter;
use App\Enums\Role;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    private $pagenateNum;

    public function __construct()
    {
        $this->pagenateNum = 15;
    }

    public function __invoke(array $input): array
    {
        $isLoginUser = false;
        $companyUser = null;
        $departmentUser = null;

        if (array_key_exists('user_id', $input)) {
            $user = User::find($input['user_id']);
            $isLoginUser = ($user->id === Auth::id()) ? true : false;
        } else {
            $user = Auth::user();
            $isLoginUser = true;
        }

        if ($user->role === Role::DEPARTMENT) {
            $company = $user->companies()->first();
            $companyUser = User::where('company_id', $company->id)->where('name', $company->name)->first();
        }

        if (($user->role === Role::MANAGER) || ($user->role === Role::MEMBER)) {
            $company = $user->companies()->first();
            $department = $user->departments()->first();
            $companyUser = User::where('company_id', $company->id)->where('name', $company->name)->first();
            $departmentUser = User::where('department_id', $department->id)->where('name', $department->name)->first();
        }

        $objectives = Objective::join('quarters', 'objectives.quarter_id', '=', 'quarters.id')
            ->where('user_id', $user->id)
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'asc')
            ->select('objectives.id', 'objectives.year', 'objectives.objective', 'objectives.score', 'quarters.quarter')
            ->paginate($this->pagenateNum);

        $quarterExists = Quarter::where('company_id', $user->company_id)->exists();

        if (!$quarterExists) {
            Flash::error(__('validation.not_found_quarter'));
        }

        return [
            'user' => $user,
            'objectives' => $objectives,
            'isLoginUser' => $isLoginUser,
            'quarterExists' => $quarterExists,
            'companyUser' => $companyUser,
            'departmentUser' => $departmentUser,
        ];
    }
}
