<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('product_category_id')->default(0)->comment('產品類別ID');
            $table->string('code', 4)->comment('代碼');
            $table->string('name', 50)->comment('名稱');
            $table->string('description', 400)->nullable()->comment('內容說明');

            $table->smallInteger('car1')->default(0)->comment('車型別1價格');
            $table->smallInteger('car2')->default(0)->comment('車型別2價格');
            $table->smallInteger('car3')->default(0)->comment('車型別3價格');
            $table->smallInteger('car4')->default(0)->comment('車型別4價格');
            $table->smallInteger('car5')->default(0)->comment('車型別5價格');
            $table->smallInteger('car6')->default(0)->comment('車型別6價格');
            $table->smallInteger('car7')->default(0)->comment('車型別7價格');
            $table->smallInteger('car8')->default(0)->comment('車型別8價格');
            $table->smallInteger('car9')->default(0)->comment('車型別9價格');
            $table->smallInteger('car10')->default(0)->comment('車型別10價格');
            $table->smallInteger('car11')->default(0)->comment('車型別11價格');
            $table->smallInteger('car12')->default(0)->comment('車型別12價格');
            $table->smallInteger('car13')->default(0)->comment('車型別13價格');
            $table->smallInteger('car14')->default(0)->comment('車型別14價格');
            $table->smallInteger('car15')->default(0)->comment('車型別15價格');

            $table->string('remark', 400)->nullable()->comment('備註說明');
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
        Schema::dropIfExists('product');
    }
}
