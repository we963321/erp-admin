<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersCarRelatedColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('regular_appear_at', 36)->default('')->comment('The customer appear day in week. seperate bt comma');
            $table->string('regular_appear_at_time', 24)->default('')->comment('The customer appear day in week. seperate bt comma');
            $table->tinyInteger('reservation_notify_date')->default(7)->comment('notification to customer');
            $table->tinyInteger('car_amount')->default(0)->comment('The amount for customer\'s cars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('regular_appear_at');
            $table->dropColumn('regular_appear_at_time');
            $table->dropColumn('reservation_notify_date');
            $table->dropColumn('car_amount');
        });
    }
}
