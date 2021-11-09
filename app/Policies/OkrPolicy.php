<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class OkrPolicy
{
    use HandlesAuthorization;

    /* 閲覧 */
    public function view(User $user)
    {
        $user_types = [
            Role::ADMIN,        // Admin
            Role::COMPANY,      // 会社
            Role::DEPARTMENT,   // 部署
            Role::MANAGER,      // マネージャー
            Role::MEMBER        // 一般
        ];
        return (in_array($user->role, $user_types));
    }

    /* 追加 */
    public function create(User $user)
    {
        $user_types = [
            Role::ADMIN,        // Admin
            Role::COMPANY,      // 会社
            Role::DEPARTMENT,   // 部署
            Role::MANAGER,      // マネージャー
            Role::MEMBER        // 一般
        ];
        return (in_array($user->role, $user_types));
    }

    /* 変更 */
    public function update(User $user)
    {
        $user_types = [
            Role::ADMIN,        // Admin
            Role::COMPANY,      // 会社
            Role::DEPARTMENT,   // 部署
            Role::MANAGER,      // マネージャー
            Role::MEMBER        // 一般
        ];
        return (in_array($user->role, $user_types));
    }

    /* 削除 */
    public function delete(User $user)
    {
        $user_types = [
            Role::ADMIN,        // Admin
            Role::COMPANY,      // 会社
        ];
        return (in_array($user->role, $user_types));
    }
}
