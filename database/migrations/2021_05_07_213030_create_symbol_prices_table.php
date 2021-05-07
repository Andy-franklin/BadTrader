<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSymbolPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symbol_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('symbol_id');

            $table->float('price');

            $table->timestamps();

            $table->foreign('symbol_id')->references('id')->on('symbols');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('symbol_prices');
    }
}
