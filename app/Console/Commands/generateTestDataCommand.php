<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class generateTestDataCommand extends Command
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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $companyGroups = \App\Models\CompanyGroup::factory(5)->create();
        foreach ($companyGroups as $companyGroup) {
            $companies = \App\Models\Company::factory(2)->create([
                'company_group_id' => $companyGroup->id
            ]);
            foreach ($companies as $company) {
                $quarters = \App\Models\Quarter::factory(1)->create([
                    'company_id' => $company->id
                ]);
            }
            foreach ($quarters as $quarter) {
                $count = 0;
                while (3 !== $count) {
                    $count++;
                    $departments = \App\Models\Department::factory(2)->create([
                        'name'       => $this->getDepartmentName($count),
                        'company_id' => $company->id
                    ]);
                }
            }
            foreach ($departments as $department) {
                $users = \App\Models\User::factory(1)->create([
                    'company_id'    => $company->id,
                    'department_id' => $department->id
                ]);
            }
            foreach ($users as $user) {
                $okrs = \App\Models\Okr::factory(1)->create([
                    'user_id'       => $user->id,
                    'quarter_id'    => $quarter->id,
                ]);
            }
            foreach ($okrs as $okr) {
                \App\Models\Objective::factory(2)->create([
                    'okr_id'       => $okr->id,
                ]);
            }
        }
    }

    private function getDepartmentName(int $count)
    {
        return 'テスト事業部' . $count;
    }
}
