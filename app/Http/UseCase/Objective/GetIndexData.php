<?php
namespace App\Http\UseCase\Objective;

use App\Models\Objective;
use App\Models\User;
use App\Enums\Role;
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

        // TODO: 現在ログイン中のユーザに紐づく会社IDの一覧だけを取得するようにする
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
            ->paginate($this->pagenateNum);

        return [
            'user' => $user,
            'objectives' => $objectives,
            'isLoginUser' => $isLoginUser,
            'companyUser' => $companyUser,
            'departmentUser' => $departmentUser,
        ];
    }
}
