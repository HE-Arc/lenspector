<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name');
            $table->string('slug')->unique();
            $table->string('department');
            $table->string('street_name');
            $table->string('building_number');
            $table->integer('post_code')->unsigned();
            $table->string('city');
            $table->integer('country_id')->unsigned();
            $table->string('phone_number');
            $table->string('fax_number');
            $table->string('email');
            $table->string('vat');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('customers');
    }
}
