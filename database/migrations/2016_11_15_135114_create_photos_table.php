<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('photo_id');
            $table->string('photo');
            $table->integer('category_id');
            $table->integer('instance_id');
            $table->string('image_type')->nullable();
            $table->tinyInteger('main')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('photos');
    }

}
