<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateColumnCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->double('usd_rate')->default(1)->after('slug');
            $table->double('irr_rate')->default(1)->after('usd_rate');
            $table->double('exchange')->default(1)->after('irr_rate');
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
            $table->dropColumn('usd_rate');
            $table->dropColumn('irr_rate');
            $table->dropColumn('exchange');
        });
    }
}
