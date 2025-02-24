<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('track_id')->unique();
            $table->string('external_id')->nullable();
            $table->integer('category_id');
            $table->string('ssn', 20)->nullable();
            $table->string('restaurant_name');
            $table->string('slug', 100);
            $table->string('order_no')->nullable();
            $table->string('currency')->nullable();
            $table->string('phone')->nullable();
            $table->float('stars')->nullable();
            $table->Text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->string('website')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->string('social_1')->nullable();
            $table->string('social_2')->nullable();
            $table->string('social_3')->nullable();
            $table->string('social_4')->nullable();
            $table->string('source',50)->nullable();
             $table->string('deeplink')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Deleted']);
            $table->integer('created_by');
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
        Schema::dropIfExists('restaurants');
    }
}
