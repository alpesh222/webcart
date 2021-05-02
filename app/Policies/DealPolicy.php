<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    public function read(User $user)
    {
        return $this->getPermission($user, 51);
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 50);
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 52);
    }

    public function delete(User $user)
    {
        return $this->getPermission($user, 53);
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
