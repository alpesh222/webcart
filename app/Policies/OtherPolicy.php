<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OtherPolicy
{
    use HandlesAuthorization;

    public function viewDashboard(User $user)
    {
        return $this->getPermission($user, 24);
    }
    
    public function updateSettings(User $user)
    {
        return $this->getPermission($user, 25);
    }

    public function updateTemplateSettings(User $user)
    {
        return $this->getPermission($user, 86);
    }
    
    public function viewCustomers(User $user)
    {
        return $this->getPermission($user, 26);
    }

    public function updateCustomers(User $user)
    {
        return $this->getPermission($user, 45);
    }

    public function viewSales(User $user)
    {
        return $this->getPermission($user, 27);
    }

    public function updatePaymentSettings(User $user)
    {
        return $this->getPermission($user, 42);
    }

    public function updateDeliverySettings(User $user)
    {
        return $this->getPermission($user, 85);
    }

    public function updateBusinessSettings(User $user)
    {
        return $this->getPermission($user, 43);
    }

    public function updateEmailSettings(User $user)
    {
        return $this->getPermission($user, 44);
    }

    public function updateSMSSettings(User $user)
    {
        return $this->getPermission($user, 67);
    }

    public function updateCSSSettings(User $user)
    {
        return $this->getPermission($user, 61);
    }

    public function updateSubscribersSettings(User $user)
    {
        return $this->getPermission($user, 60);
    }

    public function importDeleteSubscribers(User $user)
    {
        return $this->getPermission($user, 62);
    }

    public function viewReports(User $user)
    {
        return $this->getPermission($user, 58);
    }

    public function viewSubscribers(User $user)
    {
        return $this->getPermission($user, 59);
    }

    public function manageShipmentOrders(User $user)
    {
        return $this->getPermission($user, 72);
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
