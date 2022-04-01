<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit');
            $table->string('customer');
            $table->string('customerContact');
            $table->string('service_type');
            $table->mediumText('service_desc');
            $table->string('service_date');
            $table->string('service_end')->nullable();
            $table->string('nextServiceDate')->nullable();
            $table->string('nextServiceCounter')->nullable();
            $table->string('remarks')->nullable();
            $table->string('notPerformedActions')->nullable();
            $table->string('doneDate')->nullable();
            $table->boolean('critical')->nullable();
            $table->string('service_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('services');
    }
}
