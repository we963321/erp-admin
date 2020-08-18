<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('customer_category_id')->default(0)->comment('會員種類ID');
            $table->string('code', 4)->comment('代碼');
            $table->string('name', 40)->comment('名稱');
            $table->string('description', 400)->nullable()->comment('內容說明');
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
        Schema::dropIfExists('customer_service');
    }
}
