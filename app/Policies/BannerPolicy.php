<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
{
    use HandlesAuthorization;

    public function read(User $user)
    {
        return $this->getPermission($user, 37);
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 36);
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 38);
    }

    public function delete(User $user)
    {
        return $this->getPermission($user, 39);
    }

    private function getPermission($user, $permission_id)
    {
        if($user->role) {
            foreach($user->role->permissions as $permission) {
                if($permission->id == $permission_id) {
                    return true;
                }
            }
        }

        return false;
    }

    public function before($user, $ability)
    {
        if($user->isSuperAdmin()) {
            return true;
        }
    }
}