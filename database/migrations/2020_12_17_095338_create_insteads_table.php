<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsteadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insteads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->text('link')->nullable();
            $table->integer('price')->nullable();
            $table->integer('count')->nullable();
            $table->integer('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('delivery')->nullable();
            $table->text('comment')->nullable();
            $table->integer('collebration')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insteads');
    }
}
