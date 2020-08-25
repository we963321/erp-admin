<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->comment('reference the customer id.');
            $table->bigInteger('contact_id')->comment('reference the parent id.');
            $table->string('title', 64)->default('')->comment('describe the contact title');
            $table->string('content', 500)->default('')->comment('The contact content');
            $table->string('remark', 300)->default('')->comment('remark');
            $table->tinyInteger('direction')->default(1)->comment('The contact');
            $table->bigInteger('created_by')->nullable('')->comment('The admin who created this rowas');
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
        Schema::dropIfExists('customer_contacts');
    }
}
