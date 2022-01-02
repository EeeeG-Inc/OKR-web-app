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
        Quarter::QUARTER_ONE       => '第１Ｑ',
        Quarter::QUARTER_TWO       => '第２Ｑ',
        Quarter::QUARTER_THREE     => '第３Ｑ',
        Quarter::QUARTER_FOUR      => '第４Ｑ',
    ],
];
