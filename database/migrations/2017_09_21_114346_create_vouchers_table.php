<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');

            // The voucher code
            $table->string('code')->nullable();

            // The human readable voucher code name
            $table->string('name');

            // The description of the voucher
            $table->text('description')->nullable();

            // The number of uses currently
            $table->integer('uses')->unsigned()->nullable();

            // The max uses this voucher has
            $table->integer('max_uses')->unsigned()->nullable();

            // How many times a user can use this voucher.
            $table->integer('max_uses_user')->unsigned()->nullable();

            // The type can be: coupon, discount
            $table->tinyInteger('type')->unsigned();

            // The amount to discount by
            $table->decimal('discount_amount', 12, 2)->unsigned();

            // Whether or not the voucher is a percentage or a fixed price. 
            $table->boolean('is_fixed')->default(true);

            // When the voucher begins
            $table->dateTime('starts_at')->nullable();

            // When the voucher ends
            $table->dateTime('expires_at')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
