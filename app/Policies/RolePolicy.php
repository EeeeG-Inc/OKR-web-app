<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    // 閲覧
    public function view(User $user)
    {
        $userTypes = [
            Role::ADMIN,
            Role::COMPANY,
            Role::DEPARTMENT,
            Role::MANAGER,
            Role::MEMBER,
        ];
        return in_array($user->role, $userTypes);
    }

    // 追加
    public function create(User $user)
    {
        $userTypes = [
            Role::ADMIN,
            Role::COMPANY,
            Role::DEPARTMENT,
            Role::MANAGER,
            Role::MEMBER,
        ];
        return in_array($user->role, $userTypes);
    }

    // 変更
    public function update(User $user)
    {
        $userTypes = [
            Role::ADMIN,
            Role::COMPANY,
            Role::DEPARTMENT,
            Role::MANAGER,
            Role::MEMBER,
        ];
        return in_array($user->role, $userTypes);
    }

    // 削除
    public function delete(User $user)
    {
        $userTypes = [
            Role::ADMIN,
            Role::COMPANY,
        ];
        return in_array($user->role, $userTypes);
    }
}
