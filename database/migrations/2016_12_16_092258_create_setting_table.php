<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('support_email');
            $table->string('sale_email');
            $table->string('contact_no', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('city', '50')->nullable();
            $table->string('state', '50')->nullable();
            $table->string('zipcode');
            $table->string('map_iframe');
            $table->string('google_analytic');
            $table->string('social_1')->nullable();
            $table->string('social_2')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('_token',100);
            $table->rememberToken();
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
        Schema::dropIfExists('setting');
    }
}
