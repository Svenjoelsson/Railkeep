<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakeListTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makeList', function (Blueprint $table) {
            $table->increments('id');
            $table->string('make');
            $table->integer('level')->nullable();
            $table->string('serviceName');
            $table->integer('operationDays')->nullable();
            $table->integer('calendarDays')->nullable();
            $table->string('counterType');
            $table->string('counter')->nullable();
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
        Schema::drop('makeList');
    }
}
