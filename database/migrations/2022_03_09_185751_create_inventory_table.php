<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit')->nullable();
            $table->text('partNumber');
            $table->string('partName');
            $table->string('usageCounter')->nullable();
            $table->string('status');
            $table->string('critical')->default(0);
            $table->string('batch')->nullable();
            $table->string('maintenance')->nullable();
            $table->string('eol')->nullable();
            $table->string('eolDate')->nullable();
            $table->string('dateMounted')->nullable();
            $table->string('dateUnmounted')->nullable();
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
        Schema::drop('inventory');
    }
}
