<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerProjectMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_project_map', function (Blueprint $table) {
            $table->bigInteger('customer_id');
            $table->bigInteger('project_id');
            $table->bigInteger('car_id')->nullable();
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_project_map');
    }
}
