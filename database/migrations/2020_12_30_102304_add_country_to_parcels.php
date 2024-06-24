<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryToParcels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->text('country')->nullable();
            $table->text('country_out')->nullable();
            $table->text('city')->nullable();
            $table->integer('prod_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('country_out');
            $table->dropColumn('city');
            $table->dropColumn('prod_price');
        });
    }
}
