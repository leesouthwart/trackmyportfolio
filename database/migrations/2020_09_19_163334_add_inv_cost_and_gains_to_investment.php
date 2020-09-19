<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvCostAndGainsToInvestment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investments', function (Blueprint $table) {
            //
            $table->decimal('investment_cost')->nullable();
            $table->decimal('percent_gain')->default('0.00');
            $table->decimal('gain')->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investments', function (Blueprint $table) {
            //
            $table->dropColumn('investment_cost');
            $table->dropColumn('percent_gain');
            $table->dropColumn('gain');
        });
    }
}
