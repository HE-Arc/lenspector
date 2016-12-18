<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateLenseStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
        });

        Schema::table('lense', function ($table) {
            $table->integer('status')->unsigned()->nullable();
            $table->foreign('status')->references('id')->on('inventory_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('inventory_statuses');
    }
}
