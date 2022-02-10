<?php

namespace App\Services\OKR;

use App\Enums\Role;
use App\Models\User;
use App\Models\Objective;
use App\Models\Quarter;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchService
{
    /** @var int */
    private $pagenateNum;

    public function __construct()
    {
        $this->pagenateNum = 15;
    }

    public function getObjectives(array $input, int $userId): LengthAwarePaginator
    {
        $builder = Objective::join('quarters', 'objectives.quarter_id', '=', 'quarters.id')
            ->where('user_id', $userId);

        if (!is_null($input['year'] ?? null)) {
            $builder->where('year', $input['year']);
        }

        return $builder
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'asc')
            ->select('objectives.id', 'objectives.year', 'objectives.objective', 'objectives.score', 'quarters.quarter', 'objectives.priority')
            ->paginate($this->pagenateNum);
    }

    public function getRelativeUsers(User $user): array
    {
        $companyUser = null;
        $departmentUser = null;

        switch ($user->role) {
            case Role::DEPARTMENT:
                $company = $user->companies()->first();
                $companyUser = User::where('company_id', $company->id)->where('name', $company->name)->first();
                $departmentUser = null;
                break;
            case Role::MANAGER:
            case Role::MEMBER:
                $company = $user->companies()->first();
                $companyUser = User::where('company_id', $company->id)->where('name', $company->name)->first();
                $department = $user->departments()->first();
                $departmentUser = User::where('department_id', $department->id)->where('name', $department->name)->first();
                break;
        }

        return [
            'company_user' => $companyUser,
            'department_user' => $departmentUser,
        ];
    }

    public function getUserInfo(array $input): array
    {
        if (array_key_exists('user_id', $input)) {
            $user = User::find($input['user_id']);
            $isLoginUser = ($user->id === Auth::id()) ? true : false;
        } else {
            $user = Auth::user();
            $isLoginUser = true;
        }

        return [
            'user' => $user,
            'is_login_user' => $isLoginUser,
        ];
    }

    public function getYears(int $userId): array
    {
        $hasYears = Objective::where('user_id', $userId)
            ->distinct()
            ->orderBy('year', 'desc')
            ->select('year')
            ->get()
            ->pluck('year')
            ->all();

        $years = [];
        foreach ($hasYears as $y) {
            $years[$y] = $y;
        }

        return $years;
    }

    public function getQuarterExists(int $companyId): bool
    {
        $quarterExists = Quarter::where('company_id', $companyId)->exists();

        if (!$quarterExists) {
            Flash::error(__('validation.not_found_quarter'));
        }

        return $quarterExists;
    }
}
