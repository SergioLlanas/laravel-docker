<?php

namespace App\DataSource\Database;

use App\Models\Coin;
use Exception;
use Illuminate\Support\Facades\DB;

class CoinDataSource{

    public function getCoinById(String $coin_id):Coin{
        $coin = Coin::query()->where('coin_id', $coin_id)->first();
        if (is_null($coin)) {
            throw new Exception('Coin not found');
        }
        return $coin;
        //return DB::table('coins')->where('coin_id',$id)->first();
    }

    public function getCoinNameById(String $coin_id): String{
        $coin = Coin::query()->where('coin_id', $coin_id)->first();
        if (is_null($coin)) {
            throw new Exception('Coin not found');
        }
        return $coin->nameCoin;

    }

    public function getCoinSymbolById(String $coin_id): String{
        $coin = Coin::query()->where('coin_id', $coin_id)->first();
        if (is_null($coin)) {
            throw new Exception('Coin not found');
        }
        return $coin->symbol;
    }

   public function doNewTransaction(String $coin_id, String $wallet_id, int $amount_usd,String $name, String $symbol,float $buy_price){
       DB::table('coins')->insert([
           'coin_id' => $coin_id,
           'nameCoin' => $name,
           'symbol' => $symbol,
           'wallet_id' => $wallet_id,
           'buy_price' => $buy_price,
           'amount_coins' => $amount_usd/$buy_price
       ]);
   }

   public function getAmountCoinByIdAndWallet(String $coin_id,String $walletId){
       $coin = DB::select('select * from coins where coin_id = "'.$coin_id.'" and wallet_id = "'.$walletId.'" ');
       if (is_null($coin)) {
           throw new Exception('Coin not found');
       }
       return $coin->amout_coins;
   }

   public function updateAmountCoinByIdAndWallet(String $coin_id,String $amount_coin, String $walletId){
        DB::update('update coins set amount_coins = "'.$amount_coin.'" where coin_id = "'.$coin_id.'" and wallet_id = "'.$walletId.'" ');
   }

}
