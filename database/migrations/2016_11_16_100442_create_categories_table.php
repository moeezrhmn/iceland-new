<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('external_id')->nullable();
            $table->string('cat_name', 100);
            $table->string('slug', 100);
            $table->string('code', 20)->unique();
            $table->string('order_no', 10);
            $table->string('cat_image')->nullable();
            $table->string('icon')->nullable();
            $table->integer('parent_id');
            $table->enum('status', ['Active', 'Inactive', 'Deleted']);
            $table->smallInteger('created_by');
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
        Schema::dropIfExists('categories');
    }

}
