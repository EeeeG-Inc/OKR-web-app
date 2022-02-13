<?php

namespace App\Services\CompanyGroup;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\CompanyGroupRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\CompanyGroupRepository;
use DB;

class UpdateService
{
    private $companyRepo;
    private $companyGroupRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo = null, CompanyGroupRepositoryInterface $companyGroupRepo = null)
    {
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
        $this->companyGroupRepo = $companyGroupRepo ?? new CompanyGroupRepository();
    }

    public function exchangeIsMaster(array $input): void
    {
        $company = $this->companyRepo->find($input['company_id']);
        $oldCompanyGroupId = $company->company_group_id;
        $companies = $this->companyRepo->getByCompanyGroupId($oldCompanyGroupId);

        DB::beginTransaction();

        try {
            // 新しい company_groups のレコードを追加
            $newCompanyGroupId = $this->companyGroupRepo->create([
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
            $companyGroup = $this->companyGroupRepo->find($oldCompanyGroupId);
            $this->companyGroupRepo->delete($companyGroup);
        } catch (\Exception $exc) {
            DB::rollBack();
        }
        DB::commit();
    }
}
