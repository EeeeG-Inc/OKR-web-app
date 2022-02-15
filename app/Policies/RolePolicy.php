<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    // index
    public function viewAny(User $user)
    {
        return true;
    }

    // show
    public function view(User $user)
    {
        $whiteList = [
            Role::ADMIN,
            Role::COMPANY,
            Role::DEPARTMENT,
            Role::MANAGER,
            Role::MEMBER,
        ];
        return in_array($user->role, $whiteList);
    }

    // create / store
    public function create(User $user)
    {
        $whiteList = [
            Role::COMPANY,
            Role::DEPARTMENT,
            Role::MANAGER,
            Role::MEMBER,
        ];
        return in_array($user->role, $whiteList);
    }

    // edit / update
    public function update(User $user)
    {
        $whiteList = [
            Role::COMPANY,
            Role::DEPARTMENT,
            Role::MANAGER,
            Role::MEMBER,
        ];
        return in_array($user->role, $whiteList);
    }

    // destroy
    public function delete(User $user)
    {
        $whiteList = [
            Role::COMPANY,
            Role::DEPARTMENT,
            Role::MANAGER,
        ];
        return in_array($user->role, $whiteList);
    }


    // show
    public function adminOnly(User $user)
    {
        $whiteList = [
            Role::ADMIN,
        ];
        return in_array($user->role, $whiteList);
    }
}
