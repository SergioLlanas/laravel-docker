<?php


namespace App\DataSource\database;


use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\StrictSessionHandler;

class CoinDataSource{

    public function getCoinById(String $id){
        return DB::table('coins')->where('coin_id',$id)->first();
    }

    public function getCoinNameById(String $id): String{
        $coin = $this->getCoinById($id);
        return $coin->name;
    }

    public function getCoinSymbolById(String $id): String{
        $coin = $this->getCoinById($id);
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

}
