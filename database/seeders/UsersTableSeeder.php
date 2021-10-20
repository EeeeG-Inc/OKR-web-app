<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
            [
                'name'              =>  'EeeeG',
                'companies_id'      =>  '1',
                'departments_id'    =>  '',
                'role'              =>  Role::COMPANY,
                'mail'              =>  'eeeeg@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  'システム事業部',
                'companies_id'      =>  '1',
                'departments_id'    =>  '1',
                'role'              =>  Role::DEPARTMENT,
                'mail'              =>  'shisutemu@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  '総務部',
                'companies_id'      =>  '1',
                'departments_id'    =>  '2',
                'role'              =>  Role::DEPARTMENT,
                'mail'              =>  'soumu@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  '片伯部',
                'companies_id'      =>  '1',
                'departments_id'    =>  '1',
                'role'              =>  Role::MEMBER,
                'mail'              =>  'katakabe@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  '池田',
                'companies_id'      =>  '1',
                'departments_id'    =>  '1',
                'role'              =>  Role::MANAGER,
                'mail'              =>  'ikeda@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  '小林',
                'companies_id'      =>  '1',
                'departments_id'    =>  '3',
                'role'              =>  Role::MEMBER,
                'mail'              =>  'kobayashi@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'TRUE'
            ],
            [
                'name'              =>  '山田',
                'companies_id'      =>  '2',
                'departments_id'    =>  '5',
                'role'              =>  Role::MANAGER,
                'mail'              =>  'yamada@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('users')->insert($seed);
        }
    }
}
