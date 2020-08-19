<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', [0, 1])->default(1)->comment('分店類別 1=分店, 0=總公司');
            $table->string('name')->comment('角色名稱');
            $table->string('description')->comment('備註');
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
        Schema::dropIfExists('admin_roles');
    }
}
