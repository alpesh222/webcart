<?php

namespace App\Policies;

use App\User;
use App\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function read(User $user)
    {
        return $this->getPermission($user, 55);
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 54);
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 56);
    }

    public function delete(User $user)
    {
        return $this->getPermission($user, 57);
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
