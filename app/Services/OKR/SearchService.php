<?php

namespace App\Services\OKR;

use App\Enums\Role;
use App\Models\User;
use App\Models\Objective;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\ObjectiveRepository;
use App\Repositories\QuarterRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchService
{
    /** @var int */
    private $pagenateNum;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    /** @var QuarterRepositoryInterface */
    private $quarterRepo;

    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(
        ObjectiveRepositoryInterface $objectiveRepo = null,
        QuarterRepositoryInterface $quarterRepo = null,
        UserRepositoryInterface $userRepo = null
    ) {
        $this->pagenateNum = 15;
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function getObjectives(array $input, int $userId, bool $isArchived): LengthAwarePaginator
    {
        // FIXME: Repository に定義
        $builder = Objective::join('quarters', 'objectives.quarter_id', '=', 'quarters.id')
            ->where('user_id', $userId)
            ->where('is_archived', $isArchived);

        if (!is_null($input['year'] ?? null)) {
            $builder->where('year', $input['year']);
        }

        return $builder
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'asc')
            ->orderBy('priority', 'asc')
            ->select('objectives.id', 'objectives.year', 'objectives.objective', 'objectives.score', 'objectives.quarter_id', 'objectives.priority')
            ->paginate($this->pagenateNum);
    }

    public function getRelativeUsers(User $user): array
    {
        $companyUser = null;
        $departmentUser = null;

        switch ($user->role) {
            case Role::DEPARTMENT:
                $companyUser = $this->findRelativeCompanyUser($user);
                $departmentUser = null;
                break;
            case Role::MANAGER:
            case Role::MEMBER:
                $companyUser = $this->findRelativeCompanyUser($user);
                $departmentUser = $this->findRelativeDepartmentUser($user);
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
            $user = $this->userRepo->find($input['user_id']);
            $isLoginUser = $user->id === Auth::id() ? true : false;
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
        $hasYears = $this->objectiveRepo->getYearByUserId($userId);
        $years = [];
        foreach ($hasYears->pluck('year')->all() as $year) {
            $years[$year] = $year;
        }

        return $years;
    }

    public function isQuarterExists(int $companyId): bool
    {
        $quarters = $this->quarterRepo->getByCompanyId($companyId);

        if ($quarters->count() !== 4) {
            Flash::error(__('validation.not_found_quarter'));
            return false;
        }

        return true;
    }

    private function findRelativeCompanyUser(User $user): User
    {
        $company = $user->company()->first();
        return $this->userRepo->getCompanyUserByCompanyIdAndName($company->id, $company->name)->first();
    }

    private function findRelativeDepartmentUser(User $user): User
    {
        $department = $user->department()->first();
        return $this->userRepo->getDepartmentUserByCompanyIdAndName($department->id, $department->name)->first();
    }
}
