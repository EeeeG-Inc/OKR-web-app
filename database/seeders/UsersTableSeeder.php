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
                'role'              =>  Role::company,
                'mail'              =>  'eeeeg@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  'システム事業部',
                'companies_id'      =>  '1',
                'departments_id'    =>  '1',
                'role'              =>  Role::department,
                'mail'              =>  'shisutemu@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  '総務部',
                'companies_id'      =>  '1',
                'departments_id'    =>  '2',
                'role'              =>  Role::department,
                'mail'              =>  'soumu@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  '片伯部',
                'companies_id'      =>  '1',
                'departments_id'    =>  '1',
                'role'              =>  Role::member,
                'mail'              =>  'katakabe@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  '池田',
                'companies_id'      =>  '1',
                'departments_id'    =>  '1',
                'role'              =>  Role::manager,
                'mail'              =>  'ikeda@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'FALSE'
            ],
            [
                'name'              =>  '小林',
                'companies_id'      =>  '1',
                'departments_id'    =>  '3',
                'role'              =>  Role::member,
                'mail'              =>  'kobayashi@hoge.hoge',
                'password'          =>  'password',
                'delete_flag'       =>  'TRUE'
            ],
            [
                'name'              =>  '山田',
                'companies_id'      =>  '2',
                'departments_id'    =>  '5',
                'role'              =>  Role::maneger,
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
