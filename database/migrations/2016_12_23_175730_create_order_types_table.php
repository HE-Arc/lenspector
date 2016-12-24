<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->string('slug', 191)->unique();
            $table->integer('inventory_status_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('orders', function ($table) {
            $table->foreign('order_type_id')->references('id')->on('order_types');
        });
        Schema::table('order_types', function ($table) {
            $table->foreign('inventory_status_id')->references('id')
                ->on('inventory_statuses');
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
        Schema::dropIfExists('order_types');
    }
}
