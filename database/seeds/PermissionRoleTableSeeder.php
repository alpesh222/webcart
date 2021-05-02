<?php

use Illuminate\Database\Seeder;
use App\Role;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$permissionIds = [1, 2, 3, 54, 55, 56, 57, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 40, 41, 32, 33, 34, 35, 46, 47, 48, 49, 36, 37, 38, 39, 50, 51, 52, 53, 24, 26, 27, 58, 59];

        $role = Role::find(2);

        if($role) {
        	$role->permissions()->sync($permissionIds);
        }
    }
}
