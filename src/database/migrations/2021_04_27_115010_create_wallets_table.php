<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->string('wallet_id')->primary();
            //$table->string('');
            //$table->float('amount_usd');
            $table->string('coin_id');
            $table->foreign('coin_id')->references('coin_id')->on('coins');
            $table->float('buy_price');
            $table->float('amount_coins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
