<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_goods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('parcel_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('currency')->nullable();
            $table->integer('price')->default(0);

            //$table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcel_goods');
    }
}
