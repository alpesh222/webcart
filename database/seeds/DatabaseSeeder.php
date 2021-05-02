<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
		$this->call(PermissionsTableSeeder::class);
		$this->call(PermissionRoleTableSeeder::class);
		$this->call(CurrenciesTableSeeder::class);
        $this->call(CountryTableSeeder::class);
    }
}
