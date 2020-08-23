<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->nullable()->comment('referance customer');
            $table->string('customer_name', 10)->nullable()->comment('customer name if referance not exists');
            $table->bigInteger('series_id')->nullable()->comment('referance brand series');
            $table->bigInteger('color_id')->nullable()->comment('referance color');
            $table->string('color_remark', 40)->nullable()->comment('color remark');
            $table->string('years', 4)->default('')->comment('car model');
            $table->string('displacement', 4)->default('')->comment('car engine displacement');
            $table->string('model', 20)->default('')->comment('car model');
            $table->string('number', 10)->default('')->comment('car number');
            $table->date('inspected_at')->nullable()->comment('car inspection date');
            $table->date('ci_expired_at')->nullable()->comment('car compulsory insurance expired date');
            $table->date('insurance_expired_at')->nullable()->comment('car inspection expired date');
            $table->string('log_surface')->nullable()->comment('car surface check log');
            $table->tinyInteger('type')->default(1)->comment('car type');
            $table->tinyInteger('bought_type')->default(1)->comment('car bought type');
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
        Schema::dropIfExists('customer_cars');
    }
}
