<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryCurrencyAdvertisementTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('advertisements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('p_country_id');
            $table->unsignedBigInteger('p_currency_id');
            $table->bigInteger('amount_from');
            $table->bigInteger('amount_to');
            $table->unsignedBigInteger('r_country_id');
            $table->unsignedBigInteger('r_currency_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('p_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('p_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('r_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('r_currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('advertisements');
    }
}
