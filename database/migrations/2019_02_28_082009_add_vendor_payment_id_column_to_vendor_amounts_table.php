<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorPaymentIdColumnToVendorAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_amounts', function (Blueprint $table) {
            $table->integer('vendor_payment_id')->index()->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_amounts', function (Blueprint $table) {
            $table->dropColumn('vendor_payment_id');
        });
    }
}
