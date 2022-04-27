<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit')->unique();
            $table->string('make');
            $table->string('model')->nullable();
            $table->string('year_model')->nullable();
            $table->string('traction_force')->nullable();
            $table->string('customer')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('maintenanceType');
            $table->tinyInteger('inService')->default(1);
            $table->string('trackerId')->nullable();
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
        Schema::drop('units');
    }
}
