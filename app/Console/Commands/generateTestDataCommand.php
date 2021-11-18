<?php

namespace App\Console\Commands;

use \App\Enums\Role;
use \App\Models\CompanyGroup;
use \App\Models\Company;
use \App\Models\Department;
use \App\Models\Objective;
use \App\Models\Okr;
use \App\Models\Quarter;
use \App\Models\User;
use \Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenerateTestDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $companyCount;
    private $departmentCount;
    private $okrCount;
    private $objectiveCount;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->companyCount = 2;
        $this->departmentCount = 3;
        $this->okrCount = 3;
        $this->objectiveCount = 3;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // CompanyGroup作成
        $companyGroups = CompanyGroup::factory(5)->create();

        // Adminの作成
        $this->createUsersForAdmin();

        foreach ($companyGroups as $companyGroup) {
            // Company作成
            $i = 0;
            $companyIds = [];
            while ($this->companyCount !== $i) {
                $companyIds[] = Company::factory()->create([
                    'company_group_id'  => $companyGroup->id,
                    'is_master'         => $this->getIsMaster($i)
                ])->id;
                $i++;
            }

            foreach ($companyIds as $companyId) {
                // Quarter作成
                $quarterIds = [];
                $quarterIds[] = $this->createQuarter($companyId, 4, 6)->id;
                $quarterIds[] = $this->createQuarter($companyId, 7, 9)->id;
                $quarterIds[] = $this->createQuarter($companyId, 10, 12)->id;
                $quarterIds[] = $this->createQuarter($companyId, 1, 3)->id;

                // Department作成
                $i = 0;
                $departmentIds = [];
                while ($this->departmentCount !== $i) {
                    $departmentIds[] = Department::factory()->create([
                        'name'       => $this->getDepartmentName($i),
                        'company_id' => $companyId
                    ])->id;
                    $i++;
                }

                // User 作成
                $userIdsList = [];
                $userIdsList[] = $this->createUsersForCompany($companyId, null);
                foreach ($departmentIds as $departmentId) {
                    $userIdsList[] = $this->createUsersForDepartmentAndManagerAndMember($companyId, $departmentId);
                }

                // Okr と Objective 作成
                foreach ($userIdsList as $userIds) {
                    foreach ($userIds as $userId) {
                        // 三期分のデータ作成
                        $dt = Carbon::now()->subYear();
                        foreach ($quarterIds as $quarterId) {
                            $this->createOkrAndObjective($userId, $quarterId, $dt->year);
                        }
                        $dt = Carbon::now();
                        foreach ($quarterIds as $quarterId) {
                            $this->createOkrAndObjective($userId, $quarterId, $dt->year);
                        }
                        $dt->addYear();
                        foreach ($quarterIds as $quarterId) {
                            $this->createOkrAndObjective($userId, $quarterId, $dt->year);
                        }
                    }
                }
            }
        }
    }

    private function getDepartmentName(int $index) :string
    {
        $departments = [
            '営業部',
            '総務部',
            'システム事業部'
        ];
        return $departments[$index];
    }

    private function getIsMaster(int $index)
    {
        if ($index == 0) {
            return true;
        }
        return false;
    }

    private function createQuarter(int $companyId, int $from, int $to) :Quarter
    {
        return Quarter::factory()->create([
            'from'       => $from,
            'to'         => $to,
            'company_id' => $companyId
        ]);
    }
    private function createUsersForCompany(int $companyId) :array
    {
        $userIds = [];
        $userIds[] = User::factory()->create([
            'name'          => '株式会社テスト' . $companyId,
            'company_id'    => $companyId,
            'department_id' => null,
            'role'          => Role::COMPANY
        ])->id;
        return $userIds;
    }

    private function createUsersForDepartmentAndManagerAndMember(int $companyId, int $departmentId) :array
    {
        $userIds = [];
        $userIds[] = User::factory()->create([
            'name'          => Department::find($departmentId)->name,
            'company_id'    => $companyId,
            'department_id' => $departmentId,
            'role'          => Role::DEPARTMENT
        ])->id;
        $userIds[] = User::factory()->create([
            'company_id'    => $companyId,
            'department_id' => $departmentId,
            'role'          => Role::MANAGER
        ])->id;
        $userIds[] = User::factory()->create([
            'company_id'    => $companyId,
            'department_id' => $departmentId,
            'role'          => Role::MEMBER
        ])->id;
        return $userIds;
    }

    private function createUsersForAdmin() :int
    {
        return User::factory()->create([
            'name'          => '管理者',
            'company_id'    => null,
            'department_id' => null,
            'role'          => Role::ADMIN
        ])->id;
    }

    private function createOkrAndObjective(int $userId, int $quarterId, int $year) :void
    {
        $okrIds = [];
        $i = 0;
        while ($this->okrCount !== $i) {
            $okrIds[] = Okr::factory()->create([
                'user_id'       => $userId,
                'quarter_id'    => $quarterId,
                'year'          => $year,
            ])->id;
            $i++;
        }

        // Objective 作成
        foreach ($okrIds as $okrId) {
            $j = 0;
            while ($j !== $this->objectiveCount) {
                Objective::factory()->create([
                    'name' => 'okrs.id ' . $okrId . ' の成果指標' . ($j+1),
                    'okr_id' => $okrId,
                ]);
                $j++;
            }
        }
    }
}
