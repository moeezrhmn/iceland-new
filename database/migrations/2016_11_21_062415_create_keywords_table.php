<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordsTable extends Migration {

    public function up() {
        Schema::create('keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('keyword_name');
            $table->string('slug',100)->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Deleted']);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('keywords');
    }

}
