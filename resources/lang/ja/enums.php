<?php

use App\Enums\Quarter;
use App\Enums\Role;

return [
    Role::class => [
        Role::ADMIN         => '管理者',
        Role::COMPANY       => '会社',
        Role::DEPARTMENT    => '部署',
        Role::MANAGER       => 'マネージャー',
        Role::MEMBER        => '一般',
    ],
    Quarter::class => [
        Quarter::QUARTER_FULL_YEAR => '通年',
        Quarter::FIRST_QUARTER     => '第１Ｑ',
        Quarter::SECOND_QUARTER    => '第２Ｑ',
        Quarter::THIRD_QUARTER     => '第３Ｑ',
        Quarter::FOURTH_QUARTER    => '第４Ｑ',
    ],
];
