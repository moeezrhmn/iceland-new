<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('instant_id');
            $table->string('deals_title');
            $table->decimal('discount_price', 5, 2);
            $table->char('currency',2);
            $table->date('valid_from');
            $table->date('valid_to');
            $table->string('deals_image');
            $table->enum('status', ['Active', 'Inactive', 'Deleted']);
            $table->longText('description');
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
        Schema::dropIfExists('deals');
    }
}
