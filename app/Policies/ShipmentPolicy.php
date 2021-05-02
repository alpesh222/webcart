<?php

namespace App\Policies;

use App\User;
use App\Shipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipmentPolicy
{
    use HandlesAuthorization;

    public function read(User $user)
    {
        return $this->getPermission($user, 69);
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 68);
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 70);
    }

    public function delete(User $user)
    {
        return $this->getPermission($user, 71);
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
