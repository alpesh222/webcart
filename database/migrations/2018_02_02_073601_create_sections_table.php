<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->nullable();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->string('position')->nullable();
            $table->integer('priority')->default(1);
            $table->boolean('full_width')->default(true);
            $table->integer('category_id')->index()->unsigned()->nullable();
            $table->integer('brand_id')->index()->unsigned()->nullable();
            $table->string('position_category')->nullable();
            $table->string('position_brand')->nullable();
            $table->integer('location_id')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('sections');
    }
}
