<?php

namespace App\Services\CompanyGroup;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\CompanyGroupRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\CompanyGroupRepository;
use DB;
use Illuminate\Database\Eloquent\Collection;

class UpdateService
{
    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    /** @var CompanyGroupRepositoryInterface */
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
            $newCompanyGroupId = $this->companyGroupRepo->create(['name' => $company->name])->id;
            $this->updateIsMaster($companies, (int) $input['company_id'], $newCompanyGroupId);
            $companyGroup = $this->companyGroupRepo->find($oldCompanyGroupId);
            $this->companyGroupRepo->delete($companyGroup);
        } catch (\Exception $exc) {
            DB::rollBack();
        }
        DB::commit();
    }

    private function updateIsMaster(Collection $companies, int $companyId, int $companyGroupId): void
    {
        foreach ($companies as $company) {
            if ($company->id === $companyId) {
                $company->update([
                    'is_master' => true,
                    'company_group_id' => $companyGroupId,
                ]);
            } else {
                $company->update([
                    'is_master' => false,
                    'company_group_id' => $companyGroupId,
                ]);
            }
        }
    }
}
