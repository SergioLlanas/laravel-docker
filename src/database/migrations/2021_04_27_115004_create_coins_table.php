<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->string('coin_id')->primary();
            $table->string('nameCoin')->unique();
            $table->string('symbol');
            $table->string('wallet_id');
            //$table->foreign('wallet_id')->references('wallet_id')->on('wallets');
            $table->float('buy_price');
            $table->float('amount_coins');
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
        Schema::dropIfExists('coins');
    }
}
