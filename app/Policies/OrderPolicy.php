<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Order $order)
    {
        return $user->id == $order->user_id;
    }

    public function read(User $user)
    {
        return $this->getPermission($user, 21);
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 20);
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 22);
    }

    public function delete(User $user)
    {
        return $this->getPermission($user, 23);
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
