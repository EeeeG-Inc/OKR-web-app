<?php

namespace App\Services\CompanyGroup;

use App\Models\Company;
use App\Models\CompanyGroup;
use DB;
use Flash;

class UpdateService
{

    public function __construct()
    {
    }

    public function update(array $input): void
    {
        $company = Company::find($input['company_id']);
        $oldCompanyGroupId = $company->company_group_id;
        $companies = Company::where('company_group_id', $oldCompanyGroupId)->get();

        DB::beginTransaction();

        try {
            // 新しい company_groups のレコードを追加
            $newCompanyGroupId = CompanyGroup::create([
                'name' => $company->name,
            ])->id;

            // is_master と company_group_id を変更
            foreach ($companies as $company) {
                if ($company->id === (int) $input['company_id']) {
                    $company->update([
                        'is_master' => true,
                        'company_group_id' => $newCompanyGroupId,
                    ]);
                } else {
                    $company->update([
                        'is_master' => false,
                        'company_group_id' => $newCompanyGroupId,
                    ]);
                }
            }

            // 古い company_groups のレコードを削除
            CompanyGroup::find($oldCompanyGroupId)->delete();
        } catch (\Exception $exc) {
            DB::rollBack();
        }
        DB::commit();
    }
}
