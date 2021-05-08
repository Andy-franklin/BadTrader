<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSymbolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_symbols', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('symbol_id');
            $table->foreign('symbol_id')->references('id')->on('symbols');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            //Does the user want to trade this?
            $table->boolean('enabled');

            //If bullish only open trades into the bullish direction
            $table->boolean('bullish');
            //If bearish only open trades into the bearish direction
            $table->boolean('bearish');

            $table->float('fiat_max_allocation');

            //Minutes to wait before opening a new trade after an unsuccessful trade
            $table->integer('cool_off_period');

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
        Schema::dropIfExists('user_symbols');
    }
}
