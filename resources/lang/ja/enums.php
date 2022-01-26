<?php

use App\Enums\Priority;
use App\Enums\Quarter;
use App\Enums\Role;

return [
    Priority::class => [
        Priority::P0 => 'P0',
        Priority::P1 => 'P1',
        Priority::P2 => 'P2',
        Priority::P3 => 'P3',
        Priority::P4 => 'P4',
    ],
    Role::class => [
        Role::ADMIN      => '管理者',
        Role::COMPANY    => '会社',
        Role::DEPARTMENT => '部署',
        Role::MANAGER    => 'マネージャー',
        Role::MEMBER     => '一般ユーザ',
    ],
    Quarter::class => [
        Quarter::QUARTER_FULL_YEAR => '通年',
        Quarter::FIRST_QUARTER     => '第１Ｑ',
        Quarter::SECOND_QUARTER    => '第２Ｑ',
        Quarter::THIRD_QUARTER     => '第３Ｑ',
        Quarter::FOURTH_QUARTER    => '第４Ｑ',
    ],
];
