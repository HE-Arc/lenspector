<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderElementsTable extends Migration
{
    /**
      * Run the migrations.
      *
      * @return void
      */
     public function up()
     {
         Schema::create('order_elements', function (Blueprint $table) {
             $table->increments('id');
             $table->integer('order_id')->unsigned();
             $table->integer('product_type_id')->unsigned();
             $table->double('requested_diopter')->unsigned();
             $table->integer('lens_id')->unsigned()->nullable();
             $table->timestamps();
         });

         Schema::table('order_elements', function ($table) {
             $table->foreign('order_id')->references('id')->on('orders');
             $table->foreign('product_type_id')->references('id')
                ->on('product');
             $table->foreign('lens_id')->references('id')->on('lense');
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
         Schema::dropIfExists('order_elements');
     }
}
