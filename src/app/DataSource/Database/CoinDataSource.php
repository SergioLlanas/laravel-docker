<?php

namespace App\DataSource\Database;

use App\Models\Coin;
use App\Models\Wallet;
use Exception;
use http\QueryString;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Double;

class CoinDataSource{

    public function getCoinById(String $coin_id):Coin{
        $coin = Coin::query()->where('coin_id', $coin_id)->first();
        if (is_null($coin)) {
            throw new Exception('Coin not found');
        }
        return $coin;
        //return DB::table('coins')->where('coin_id',$id)->first();
    }

    public function getCoinsByWalletId(String $wallet_id){
        $coins = DB::table('coins')->where('wallet_id', $wallet_id)->get();
        /*$coins = Coin::query()->where('wallet_id',$wallet_id);*/
        if (is_null($coins)){
            throw new Exception('Coin not found');
        }
        return $coins;
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

    public function getAmountCoinByIdAndWallet(String $coin_id,String $wallet_id):Float{
        $coin = Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $wallet_id)->first();
        if(is_null($coin)){
            throw new Exception('Coin not found');
        }
        return floatval($coin->amount_coins);


        //$coin = DB::select('select * from coins where coin_id = "'.$coin_id.'" and wallet_id = "'.$walletId.'" order by amount_coins desc');
        /*var_dump($coin);
        if (is_null($coin)) {
            throw new Exception('Coin not found');
        }else{
            return $coin[0]->amount_coins;
        }*/

    }

    /*** FALTAN ***/
    public function doNewTransaction(String $coin_id, String $wallet_id, int $amount_usd,String $name, String $symbol,float $buy_price):String{
        $coin = Coin::query()->insertGetId(array(
            'coin_id' => $coin_id, 'nameCoin' => $name, 'symbol' => $symbol,
            'wallet_id' => $wallet_id, 'amount_coins' => $amount_usd/$buy_price
        ));
        return $coin;
   }

    public function incrementAmountCoinByIdAndWallet(String $coin_id,String $amount_coin, String $walletId){
        DB::update('update coins set amount_coins = amount_coins + "'.$amount_coin.'" where coin_id = "'.$coin_id.'" and wallet_id = "'.$walletId.'" ');
   }

    public function decrementAmountCoinByIdAndWallet(String $coin_id,String $amount_coin, String $walletId){
        DB::update('update coins set amount_coins = amount_coins - "'.$amount_coin.'" where coin_id = "'.$coin_id.'" and wallet_id = "'.$walletId.'" ');
    }

}
