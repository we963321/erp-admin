<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminUserColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function($table) {
            $table->smallInteger('branch_store_id')->default(0)->unsigned()->after('id')->comment('分店ID');
            $table->string('emp_id', 20)->default('0')->after('branch_store_id')->comment('員工編號');
            $table->enum('sex', [0, 1])->default(1)->after('password')->comment('性別 1=男, 0=女');
            $table->string('mobile', 10)->after('sex')->comment('手機');
            $table->string('id_number', 10)->after('mobile')->comment('身分證號');
            $table->string('address', 120)->after('id_number')->nullable()->comment('地址');
            $table->date('birthday')->after('address')->nullable()->comment('生日');
            $table->enum('status', [-1, 0, 1])->default(1)->after('birthday')->comment('狀態 1=啟用, 0=停用, -1=刪除');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function($table) {
            $table->dropColumn('branch_store_id');
            $table->dropColumn('emp_id');
            $table->dropColumn('sex');
            $table->dropColumn('mobile');
            $table->dropColumn('id_number');
            $table->dropColumn('address');
            $table->dropColumn('birthday');
            $table->dropColumn('status');
        });
    }
}
