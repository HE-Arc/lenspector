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
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('company_name', 191);
            $table->string('slug', 191)->unique();
            $table->string('department', 191);
            $table->string('street_name', 191);
            $table->integer('building_number')->unsigned();
            $table->integer('post_code')->unsigned();
            $table->string('city', 191);
            $table->integer('country_id')->unsigned();
            $table->string('phone_number', 191);
            $table->string('fax_number', 191);
            $table->string('email', 191);
            $table->string('vat', 191);
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
