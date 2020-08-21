<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('brand_id')->comment('referance id');
            $table->string('code', 4)->default('')->comment('The code name.');
            $table->string('name', 64)->default('')->comment('The name.');
            $table->string('description', 300)->nullable()->comment('內容說明');
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
        Schema::dropIfExists('car_series');
    }
}
