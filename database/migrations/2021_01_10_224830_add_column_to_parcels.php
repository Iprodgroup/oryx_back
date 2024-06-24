<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToParcels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->integer('payed')->default(0);
            $table->string('in_fio')->nullable();
            $table->string('in_city')->nullable();
            $table->string('in_address')->nullable();
            $table->string('in_comment')->nullable();
            $table->string('in_track')->nullable();
            $table->date('in_date')->nullable();
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
            $table->dropColumn('payed');
            $table->dropColumn('in_fio');
            $table->dropColumn('in_city');
            $table->dropColumn('in_address');
            $table->dropColumn('in_comment');
            $table->dropColumn('in_track');
            $table->dropColumn('in_date');
        });
    }
}
