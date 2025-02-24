<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('external_id')->nullable();
            $table->string('title')->nullable();
              $table->string('short_des')->nullable();
            $table->longText('description')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Deleted']);
            $table->integer('created_by');
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('articles');
    }

}
