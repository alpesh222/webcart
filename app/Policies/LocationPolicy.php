<?php

namespace App\Policies;

use App\User;
use App\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    public function read(User $user)
    {
        return $this->getPermission($user, 29);
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 28);
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 30);
    }

    public function delete(User $user)
    {
        return $this->getPermission($user, 31);
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
