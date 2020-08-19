<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('locations', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id')->nullable()->comment('父類別');
            $table->string('code', 4)->default('')->comment('The location code name.');
            $table->string('name', 64)->default('')->comment('The location key name.');
            $table->string('display_name', 64)->comment('Display nmae');
            $table->enum('status', [-1, 0, 1])->default(1)->comment('狀態 1=啟用, 0=停用, -1=刪除');
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
        //
        Schema::dropIfExists('locations');
    }
}
