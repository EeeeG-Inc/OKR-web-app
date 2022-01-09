<?php

use App\Enums\Role;

return [
    Role::class => [
        Role::ADMIN      => '管理者',
        Role::COMPANY    => '会社',
        Role::DEPARTMENT => '部署',
        Role::MANAGER    => 'マネージャー',
        Role::MEMBER     => '一般ユーザ',
    ],
];
