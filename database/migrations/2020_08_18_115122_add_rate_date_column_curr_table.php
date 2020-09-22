<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateDateColumnCurrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->timestamp('usd_rate_date')->nullable()->after('usd_rate');
            $table->timestamp('irr_rate_date')->nullable()->after('irr_rate');
            $table->timestamp('exchange_date')->nullable()->after('exchange');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('usd_rate_date');
            $table->dropColumn('irr_rate_date');
            $table->dropColumn('exchange_date');
        });
    }
}
