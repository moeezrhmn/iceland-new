<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultiKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('keyword_id');
            $table->Integer('instance_id');
            $table->Integer('category_id');
            $table->Integer('subcategory_id')->nullable();
            $table->Integer('created_by')->nullable();
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
        Schema::dropIfExists('multi_keywords');
    }
}
