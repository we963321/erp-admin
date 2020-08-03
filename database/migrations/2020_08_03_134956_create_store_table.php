<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('admin_user_id')->default(0)->comment('管理者ID');
            $table->string('name', 50)->comment('店別名稱');
            $table->string('short_name', 10)->comment('店別簡稱');
            $table->string('description', 200)->nullable()->comment('店別說明');
            $table->string('mobile', 10)->nullable()->comment('電話');
            $table->string('counties', 10)->nullable()->comment('縣市');
            $table->string('town', 10)->nullable()->comment('鄉鎮區');
            $table->string('address', 50)->nullable()->comment('地址');
            $table->string('remark', 500)->nullable()->comment('備註');
            $table->enum('status', [0, 1])->default(1)->comment('狀態 1=啟用, 0=停用');
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
        Schema::dropIfExists('store');
    }
}
