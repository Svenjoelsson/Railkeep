<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Rent', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit');
            $table->string('customer');
            $table->string('rentStart');
            $table->string('rentEnd')->nullable();
            $table->string('monthlyCost')->nullable();
            $table->string('counterCost')->nullable();
            $table->string('status');
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
        Schema::drop('Rent');
    }
}
