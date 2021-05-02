<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitializeSuperAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name'=>'Super Admin',
            'username'=>'admin',
            'email'=>'admin@domain.com',
            'password'=>bcrypt('admin'),
            'is_active'=>1,
            'role_id'=>1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->truncate();
    }
}
