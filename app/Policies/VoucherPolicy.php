<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoucherPolicy
{
    use HandlesAuthorization;

    public function readDiscount(User $user)
    {
        return $this->getPermission($user, 33);
    }

    public function createDiscount(User $user)
    {
        return $this->getPermission($user, 32);
    }

    public function updateDiscount(User $user)
    {
        return $this->getPermission($user, 34);
    }

    public function deleteDiscount(User $user)
    {
        return $this->getPermission($user, 35);
    }

    public function readCoupon(User $user)
    {
        return $this->getPermission($user, 47);
    }

    public function createCoupon(User $user)
    {
        return $this->getPermission($user, 46);
    }

    public function updateCoupon(User $user)
    {
        return $this->getPermission($user, 48);
    }

    public function deleteCoupon(User $user)
    {
        return $this->getPermission($user, 49);
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
