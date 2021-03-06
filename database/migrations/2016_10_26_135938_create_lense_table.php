<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lense', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sn', 191);
            $table->date('dateExpiration');
            $table->tinyInteger('exclude')->default(0);
            $table->integer('productId')->unsigned()->nullable();
            $table->double('SphCorrected')->unsigned();
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
        Schema::dropIfExists('lense');
    }
}
