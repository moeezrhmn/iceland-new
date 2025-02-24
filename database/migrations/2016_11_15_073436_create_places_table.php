<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('external_id')->nullable();
            $table->string('place_name');
            $table->string('track_id')->unique();
            $table->integer('category_id');
            $table->string('slug', 100);
            $table->string('ssn', 20)->nullable();
            $table->integer('order_no')->default(0);
            $table->float('stars')->nullable();
            $table->float('price')->nullable();
            $table->Text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->string('phone')->nullable();
            $table->char('currency')->nullable();
            $table->time('visit_duration')->default('1:00');
            $table->string('website_url')->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->string('social_1')->nullable();
            $table->string('social_2')->nullable();
            $table->string('social_3')->nullable();
            $table->string('social_4')->nullable();
            $table->string('source',50)->nullable();
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
        Schema::dropIfExists('places');
    }

}
