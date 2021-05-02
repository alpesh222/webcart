<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned()->default(0);
            $table->integer('category_id')->index()->unsigned()->nullable();
            $table->integer('brand_id')->index()->unsigned()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('in_stock');
            $table->decimal('price', 12, 2)->unsigned();
            $table->string('model')->nullable();
            $table->decimal('tax_rate', 12, 2)->unsigned()->default(0);
            $table->string('barcode')->nullable();
            $table->unsignedTinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('products');
    }
}
