<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('cust_id', 20)->default('0')->comment('客戶編號');
            $table->enum('sex', [0, 1])->default(1)->comment('性別 1=男, 0=女');
            $table->string('mobile', 10)->comment('手機');
            $table->string('id_number', 10)->comment('身分證號');
            $table->string('counties', 10)->nullable()->comment('縣市');
            $table->string('town', 10)->nullable()->comment('鄉鎮區');
            $table->string('address', 120)->nullable()->comment('地址');
            $table->date('birthday')->nullable()->comment('生日');
            $table->enum('marriage', [0, 1])->default(0)->comment('婚姻 1=已婚, 0=未婚');
            $table->string('customer_resource', 255)->nullable()->comment('客戶來源');
            $table->string('introducer', 50)->nullable()->comment('介紹人');
            $table->string('line', 50)->nullable()->comment('line');
            $table->string('facebook', 255)->nullable()->comment('facebook');
            $table->string('tax_number', 10)->nullable()->comment('統一編號');
            $table->enum('status', [-1, 0, 1])->default(1)->comment('狀態 1=啟用, 0=停用, -1=刪除');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('cust_id');
            $table->dropColumn('sex');
            $table->dropColumn('mobile');
            $table->dropColumn('id_number');
            $table->dropColumn('counties');
            $table->dropColumn('town');
            $table->dropColumn('address');
            $table->dropColumn('birthday');
            $table->dropColumn('marriage');
            $table->dropColumn('customer_resource');
            $table->dropColumn('introducer');
            $table->dropColumn('line');
            $table->dropColumn('facebook');
            $table->dropColumn('tax_number');
            $table->dropColumn('status');
        });
    }
}
