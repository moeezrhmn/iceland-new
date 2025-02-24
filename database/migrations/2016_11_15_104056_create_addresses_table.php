<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('address_id');
            $table->integer('instant_id');
            $table->integer('category_id')->nullable();
            $table->double('latitude', 15, 11)->nullable();
            $table->double('longitude', 15, 11)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state', '50')->nullable();
            $table->string('region', '50')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('addresses');
    }

}
