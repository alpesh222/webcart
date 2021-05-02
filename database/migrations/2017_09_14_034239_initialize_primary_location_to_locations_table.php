<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitializePrimaryLocationToLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('locations')->truncate();
        DB::table('locations')->insert([
            'name'=>'Primary',
            'address'=>'-',
            'contact_number'=>'-',
            'slug'=>'primary'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('locations')->truncate();
    }
}
