<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned()->nullable();
            $table->unsignedTinyInteger('is_processed')->default(0);
            $table->decimal('tax', 12, 2)->unsigned();
            $table->decimal('total', 12, 2)->unsigned();
            $table->string('payment_method');
            $table->string('status')->nullable()->default('To be dispatched.');
            $table->dateTime('processed_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
