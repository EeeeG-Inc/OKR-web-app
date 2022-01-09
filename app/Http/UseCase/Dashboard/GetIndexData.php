<?php
namespace App\Http\UseCase\Dashboard;

use App\Models\Company;
use App\Models\User;
use App\Enums\Role;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    /** @var int */
    private $pagenateNum;

    public function __construct()
    {
        $this->pagenateNum = 15;
    }

    public function __invoke(): array
    {
        $user = Auth::user();

        // グループ会社全員のデータを取得する
        $companyIds = Company::where('company_group_id', $user->companies->company_group_id)->pluck('id')->toArray();
        $users = User::where('role', '!=', Role::ADMIN)
            ->whereIn('company_id', $companyIds)
            ->paginate($this->pagenateNum);

        return ['users' => $users];
    }
}
