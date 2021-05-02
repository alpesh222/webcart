<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_amounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->index()->unsigned()->nullable();
            $table->integer('product_id')->index()->unsigned()->nullable();
            $table->integer('vendor_id')->index()->unsigned()->nullable();
            $table->string('product_name')->nullable();
            $table->integer('product_quantity')->nullable();
            $table->decimal('unit_price', 12, 2)->unsigned()->nullable();
            $table->decimal('total_price', 12, 2)->unsigned()->nullable();
            $table->decimal('vendor_amount', 12, 2)->unsigned()->nullable();
            $table->string('currency', 3)->default(null);
            // status: outstanding, earned, paid, cancelled
            $table->string('status')->default('outstanding');

            $table->dateTime('outstanding_date')->nullable();
            $table->dateTime('earned_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->dateTime('cancel_date')->nullable();

            $table->unsignedTinyInteger('processed')->default(0);

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_amounts');
    }
}
