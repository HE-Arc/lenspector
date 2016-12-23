<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('orders', function (Blueprint $table) {
             $table->increments('id');
             $table->integer('order_type_id')->unsigned();
             $table->integer('customer_id')->unsigned();
             $table->dateTime('requested_at')->nullable();
             $table->integer('order_status_id')->unsigned()->default(1);
             $table->dateTime('shipped_at')->nullable();
             $table->string('awb', 191)->nullable();
             $table->longText('note');
             $table->timestamps();
         });

         Schema::table('orders', function ($table) {
             $table->foreign('order_status_id')->references('id')
                ->on('order_statuses');
             $table->foreign('customer_id')->references('id')->on('customers');
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
         Schema::dropIfExists('orders');
     }
}
