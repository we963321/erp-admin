<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('customer_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 4)->comment('代碼');
            $table->string('name', 50)->comment('名稱');
            $table->string('description', 400)->nullable()->comment('內容說明');
            $table->string('feature', 200)->nullable()->comment('特色');
            $table->string('target')->comment('對象 客戶/c, 車號/n');

            $table->smallInteger('service_product_id1')->default(0)->comment('服務內容1, 產品資料ID');
            $table->decimal('service_product_num1', 6, 1)->default(0)->comment('服務內容1, 數量');
            $table->decimal('service_product_unit1', 6, 1)->default(0)->comment('服務內容1, 單位');
            $table->smallInteger('service_product_id2')->default(0)->comment('服務內容2, 產品資料ID');
            $table->decimal('service_product_num2', 6, 1)->default(0)->comment('服務內容2, 數量');
            $table->decimal('service_product_unit2', 6, 1)->default(0)->comment('服務內容2, 單位');
            $table->smallInteger('service_product_id3')->default(0)->comment('服務內容3, 產品資料ID');
            $table->decimal('service_product_num3', 6, 1)->default(0)->comment('服務內容3, 數量');
            $table->decimal('service_product_unit3', 6, 1)->default(0)->comment('服務內容3, 單位');
            $table->smallInteger('service_product_id4')->default(0)->comment('服務內容4, 產品資料ID');
            $table->decimal('service_product_num4', 6, 1)->default(0)->comment('服務內容4, 數量');
            $table->decimal('service_product_unit4', 6, 1)->default(0)->comment('服務內容4, 單位');
            $table->smallInteger('service_product_id5')->default(0)->comment('服務內容5, 產品資料ID');
            $table->decimal('service_product_num5', 6, 1)->default(0)->comment('服務內容5, 數量');
            $table->decimal('service_product_unit5', 6, 1)->default(0)->comment('服務內容5, 單位');

            $table->smallInteger('bonus_product_id1')->default(0)->comment('超值加碼1, 產品資料ID');
            $table->decimal('bonus_product_num1', 6, 1)->default(0)->comment('超值加碼1, 數量');
            $table->decimal('bonus_product_unit1', 6, 1)->default(0)->comment('超值加碼1, 單位');
            $table->smallInteger('bonus_product_id2')->default(0)->comment('超值加碼2, 產品資料ID');
            $table->decimal('bonus_product_num2', 6, 1)->default(0)->comment('超值加碼2, 數量');
            $table->decimal('bonus_product_unit2', 6, 1)->default(0)->comment('超值加碼2, 單位');
            $table->smallInteger('bonus_product_id3')->default(0)->comment('超值加碼3, 產品資料ID');
            $table->decimal('bonus_product_num3', 6, 1)->default(0)->comment('超值加碼3, 數量');
            $table->decimal('bonus_product_unit3', 6, 1)->default(0)->comment('超值加碼3, 單位');
            $table->smallInteger('bonus_product_id4')->default(0)->comment('超值加碼4, 產品資料ID');
            $table->decimal('bonus_product_num4', 6, 1)->default(0)->comment('超值加碼4, 數量');
            $table->decimal('bonus_product_unit4', 6, 1)->default(0)->comment('超值加碼4, 單位');
            $table->smallInteger('bonus_product_id5')->default(0)->comment('超值加碼5, 產品資料ID');
            $table->decimal('bonus_product_num5', 6, 1)->default(0)->comment('超值加碼5, 數量');
            $table->decimal('bonus_product_unit5', 6, 1)->default(0)->comment('超值加碼5, 單位');

            $table->smallInteger('gift_product_id1')->default(0)->comment('好禮相送1, 產品資料ID');
            $table->decimal('gift_product_num1', 6, 1)->default(0)->comment('好禮相送1, 數量');
            $table->decimal('gift_product_unit1', 6, 1)->default(0)->comment('好禮相送1, 單位');
            $table->smallInteger('gift_product_id2')->default(0)->comment('好禮相送2, 產品資料ID');
            $table->decimal('gift_product_num2', 6, 1)->default(0)->comment('好禮相送2, 數量');
            $table->decimal('gift_product_unit2', 6, 1)->default(0)->comment('好禮相送2, 單位');
            $table->smallInteger('gift_product_id3')->default(0)->comment('好禮相送3, 產品資料ID');
            $table->decimal('gift_product_num3', 6, 1)->default(0)->comment('好禮相送3, 數量');
            $table->decimal('gift_product_unit3', 6, 1)->default(0)->comment('好禮相送3, 單位');
            $table->smallInteger('gift_product_id4')->default(0)->comment('好禮相送4, 產品資料ID');
            $table->decimal('gift_product_num4', 6, 1)->default(0)->comment('好禮相送4, 數量');
            $table->decimal('gift_product_unit4', 6, 1)->default(0)->comment('好禮相送4, 單位');
            $table->smallInteger('gift_product_id5')->default(0)->comment('好禮相送5, 產品資料ID');
            $table->decimal('gift_product_num5', 6, 1)->default(0)->comment('好禮相送5, 數量');
            $table->decimal('gift_product_unit5', 6, 1)->default(0)->comment('好禮相送5, 單位');

            $table->string('remark', 500)->nullable()->comment('備註');
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
        Schema::dropIfExists('customer_project');
    }
}
