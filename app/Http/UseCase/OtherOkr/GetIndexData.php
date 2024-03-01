<?php

namespace App\Http\UseCase\OtherOkr;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    /** @var int */
    private $pagenateNum;

    /** @var UserRepositoryInterface */
    private $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo = null
    ) {
        $this->pagenateNum = 15;
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function __invoke(array $input = []): array
    {
        $user = Auth::user();

        return [
            'users' => $this->userRepo->paginateByCompanyId($this->pagenateNum, $user->company_id),
        ];
    }
}
