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
use Illuminate\Database\Eloquent\Collection;

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

    /** @var int */
    private $companyCount;
    private $departmentCount;
    private $okrCount;
    private $objectiveCount;

    /** @var string[] */
    private $departments = [
        '営業部',
        '総務部',
        'システム事業部'
    ];

    /** @var string[] */
    private $okrs = [
        '売上○○％向上',
        '○○資格取得',
        'DAU○○○○達成'
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->companyCount = 2;
        $this->departmentCount = count($this->departments);
        $this->okrCount = count($this->okrs);
        $this->objectiveCount = 3;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // CompanyGroup作成
        $companyGroups = CompanyGroup::factory(2)->create();

        // Adminの作成
        $this->createUserForAdmin();

        foreach ($companyGroups as $companyGroup) {
            // Company作成
            $i = 0;
            $companyIds = [];
            while ($this->companyCount !== $i) {
                $companyIds[] = Company::factory()->create([
                    'company_group_id'  => $companyGroup->id,
                    'is_master'         => $this->getIsMaster($i)
                ])['id'];
                $i++;
            }

            foreach ($companyIds as $companyId) {
                // Quarter作成
                $quarterIds = [];
                $quarterIds[] = $this->createQuarter($companyId, 1, 4, 6);
                $quarterIds[] = $this->createQuarter($companyId, 2, 7, 9);
                $quarterIds[] = $this->createQuarter($companyId, 3, 10, 12);
                $quarterIds[] = $this->createQuarter($companyId, 4, 1, 3);

                // Department作成
                $i = 0;
                $departmentIds = [];
                while ($this->departmentCount !== $i) {
                    $departmentIds[] = Department::factory()->create([
                        'name'       => $this->departments[$i],
                        'company_id' => $companyId
                    ])['id'];
                    $i++;
                }

                // User 作成
                $userIdsList = [];
                $userIdsList[] = $this->createUserForCompany($companyId);
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

    /**
     * 系列会社の中で最初に生成された会社 (index 0) は is_master に true を返却する
     *
     * @param int $index     0 であれば is_master を真とする
     * @return bool          is_master の真偽を返す
     */
    private function getIsMaster(int $index)
    {
        if ($index == 0) {
            return true;
        }
        return false;
    }

    /**
     * 系列会社毎 quarter の開始月と終了月を返却する
     *
     * @param int $companyId     作成する会社の companyId ※外部キー
     * @param int $quarter       何期の quarter を判別するかの指標(サンプルでは 1-4 の決め打ち)
     * @param int $from          quarter の開始月(サンプルでは決め打ち)
     * @param int $to            quarter の終了月(サンプルでは決め打ち)
     * @return int               factory を使った INSERT 項目
     */
    private function createQuarter(int $companyId, int $quarter, int $from, int $to) :int
    {
        return Quarter::factory()->create([
            'quater'     => $quarter,
            'from'       => $from,
            'to'         => $to,
            'company_id' => $companyId
        ])['id'];
    }

    /**
     * 1会社に付き1つ作成される CompanyUser の作成
     *
     * @param int $companyId     作成する会社の companyId ※外部キー
     * @return array             factory を使った INSERT 項目
     */
    private function createUserForCompany(int $companyId) :array
    {
        $userIds = [];
        $userIds[] = User::factory()->create([
            'name'          => '株式会社テスト' . $companyId,
            'company_id'    => $companyId,
            'department_id' => null,
            'role'          => Role::COMPANY
        ])['id'];
        return $userIds;
    }

    /**
     * 1部署に1つの DepartmentUser 、マネージャー権限を持った ManagerUser 、 一般権限の MemberUser の作成
     *
     * @param int $companyId     作成する会社の companyId ※外部キー
     * @param int $departmentId  作成する部署の departmentId ※外部キー
     * @return array             factory を使った INSERT 項目
     */
    private function createUsersForDepartmentAndManagerAndMember(int $companyId, int $departmentId) :array
    {
        $userIds = [];
        $userIds[] = User::factory()->create([
            'name'          => Department::find($departmentId)->name,
            'company_id'    => $companyId,
            'department_id' => $departmentId,
            'role'          => Role::DEPARTMENT
        ])['id'];
        $userIds[] = User::factory()->create([
            'company_id'    => $companyId,
            'department_id' => $departmentId,
            'role'          => Role::MANAGER
        ])['id'];
        $userIds[] = User::factory()->create([
            'company_id'    => $companyId,
            'department_id' => $departmentId,
            'role'          => Role::MEMBER
        ])['id'];
        return $userIds;
    }

    /**
     * 1アプリにつき1つのフルコントロールを持った Admin ユーザ作成
     *
     * @return void
     */
    private function createUserForAdmin() :void
    {
        User::factory()->create([
            'name'          => '管理者',
            'company_id'    => null,
            'department_id' => null,
            'role'          => Role::ADMIN
        ]);
    }

    /**
     * Okr と Objective 作成
     *
     * @param int $userId     作成する会社の companyId ※外部キー
     * @param int $quarterId  作成する quarter の quarterId ※外部キー
     * @param int $year       Okr 及び Objective に紐付ける西暦
     * @return void           factory を使った INSERT 項目
     */
    private function createOkrAndObjective(int $userId, int $quarterId, int $year) :void
    {
        // OKR 作成
        $okrIds = [];
        $i = 0;
        while ($this->okrCount !== $i) {
            $okrIds[] = Okr::factory()->create([
                'name'          => $this->okrs[$i],
                'user_id'       => $userId,
                'quarter_id'    => $quarterId,
                'year'          => $year,
            ])['id'];
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