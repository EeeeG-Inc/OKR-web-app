<?php

namespace App\Http\UseCase\CompanyGroup;

use App\Enums\Role;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{

    public function __construct()
    {
    }

    public function __invoke(): array
    {
        if (Auth::user()->role === Role::ADMIN) {
            return [];
        }

        $companyGroupId = Auth::user()->companies()->first()->company_group_id;
        $companies = Company::where('company_group_id', $companyGroupId)->get();

        return [
            'companies' => $companies,
        ];
    }
}
