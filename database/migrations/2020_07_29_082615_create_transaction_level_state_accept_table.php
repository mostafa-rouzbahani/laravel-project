<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionLevelStateAcceptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_states', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->string('name');
            $table->string('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('trans_levels', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->string('name');
            $table->string('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('trans_accepts', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->string('name');
            $table->string('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('advertisement_id')->nullable();
            $table->string('transaction_id')->unique();

            $table->unsignedBigInteger('s_user_id');
            $table->unsignedBigInteger('s_currency_id');
            $table->unsignedBigInteger('s_country_id');
            $table->unsignedInteger('transAccept_id')->nullable();
            $table->timestamp('transAccept_date')->nullable();
            $table->double('s_amount');
            $table->string('s_bank_name')->nullable();
            $table->string('s_account_number')->nullable();
            $table->string('s_account_name')->nullable();
            $table->text('s_description')->nullable();

            $table->unsignedBigInteger('b_user_id');
            $table->unsignedBigInteger('b_currency_id');
            $table->unsignedBigInteger('b_country_id');
            $table->double('b_amount');
            $table->string('b_bank_name')->nullable();
            $table->string('b_account_number')->nullable();
            $table->string('b_account_name')->nullable();
            $table->text('b_description')->nullable();

            $table->unsignedInteger('admin_money_flag')->nullable();
            $table->timestamp('admin_money_date')->nullable();
            $table->unsignedInteger('b_money_flag')->nullable();
            $table->timestamp('b_money_date')->nullable();
            $table->unsignedInteger('s_money_flag')->nullable();
            $table->timestamp('s_money_date')->nullable();
            $table->unsignedInteger('transLevel_id')->nullable();
            $table->unsignedInteger('transState_id')->nullable();
            $table->boolean('cancel_flag')->default(0);
            $table->timestamp('cancel_flag_date')->nullable();
            $table->boolean('unsuccessful_flag')->default(0);
            $table->timestamp('unsuccessful_flag_date')->nullable();

            $table->timestamps();

            $table->foreign('s_user_id')->references('id')->on('users');
            $table->foreign('s_currency_id')->references('id')->on('currencies');
            $table->foreign('s_country_id')->references('id')->on('countries');

            $table->foreign('b_user_id')->references('id')->on('users');
            $table->foreign('b_currency_id')->references('id')->on('currencies');
            $table->foreign('b_country_id')->references('id')->on('countries');

            $table->foreign('advertisement_id')->references('id')->on('advertisements')->onDelete('set null');

            $table->foreign('transLevel_id')->references('id')->on('trans_levels');
            $table->foreign('transState_id')->references('id')->on('trans_states');
            $table->foreign('transAccept_id')->references('id')->on('trans_accepts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('trans_states');
        Schema::dropIfExists('trans_levels');
        Schema::dropIfExists('trans_accepts');

    }
}
