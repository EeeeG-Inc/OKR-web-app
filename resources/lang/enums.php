<?php

use App\Enums\Role;

return [
    Role::class => [
        Role::ADMIN         => 'アドミン',
        Role::COMPANY       => '会社',
        Role::DEPARTMENT    => '部署',
        Role::MANAGER       => 'マネージャー',
        Role::MEMBER        => '一般',
    ],
];
