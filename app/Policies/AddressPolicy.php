<?php

namespace App\Policies;

use App\User;
use App\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Customer $customer)
    {
        return $user->id == $customer->user_id;
    }

    public function update(User $user, Customer $customer)
    {
        return $user->id == $customer->user_id;
    }

    public function delete(User $user, Customer $customer)
    {
        return $user->id == $customer->user_id;
    }
}
