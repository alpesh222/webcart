<?php

namespace App\Policies;

use App\User;
use App\DeliveryLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryLocationPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user,'81');
    }

    public function create(User $user)
    {

        return $this->getPermission($user,'82');
    }

    public function update(User $user)
    {
        return $this->getPermission($user,'83');
    }

    public function delete(User $user)
    {
        return $this->getPermission($user,'84');
    }

    private function getPermission($user, $permission_id){
        if($user->role){
            foreach ($user->role->permissions as $permission){
                if($permission->id == $permission_id){
                    return true;
                }
            }
        }
        return false;
    }

    public function before($user,$ability){

        if ($user->isSuperAdmin()){
            return true;
        }
    }
}
