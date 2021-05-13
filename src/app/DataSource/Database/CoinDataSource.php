<?php

namespace App\DataSource\Database;

use App\Models\Coin;
use Exception;

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

    public function existsCoinIdAndWalletId(String $coin_id, String $wallet_id):bool{
        $coin = Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $wallet_id)->first();
        if(is_null($coin)){
            throw new Exception('Coin not found');
        }
        return true;
    }

    public function getAmountCoinByIdAndWallet(String $coin_id,String $wallet_id):Float{
        $coin = Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $wallet_id)->first();
        if(is_null($coin)){
            throw new Exception('Coin not found');
        }
        return floatval($coin->amount_coins);
    }

    public function getCoinsByWalletId(String $wallet_id){
        //$coins = DB::table('coins')->where('wallet_id', $wallet_id)->get();
        $coins = Coin::query()->where('wallet_id',$wallet_id);
        if (is_null($coins)){
            throw new Exception('Coin not found');
        }
        return $coins;
    }

    public function doNewTransaction(String $coin_id, String $wallet_id, int $amount_usd,String $name, String $symbol,float $buy_price):String{

        if(is_null($coin_id) || trim($coin_id) === '' || is_null($wallet_id) || trim($wallet_id) === '' ||is_null($name) || trim($name) === ''
        || is_null($symbol) || trim($symbol) === '' || is_null($buy_price) || $buy_price<= 0 || is_null($amount_usd) || $amount_usd<= 0){
            throw new Exception('Transaction not done');
        }
        $coin = Coin::query()->insertGetId(array(
            'coin_id' => $coin_id, 'nameCoin' => $name, 'symbol' => $symbol,
            'wallet_id' => $wallet_id, 'amount_coins' => $amount_usd/$buy_price
        ));
        return $coin;
   }

    public function incrementAmountCoinByIdAndWallet(String $coin_id, float $amount_coin, String $walletId): bool{
        if(trim($coin_id) === '' ||trim($amount_coin) === '' || trim($walletId) === '' || $amount_coin <= 0){
            throw new Exception('Amount coin not updated');
        }

        $coin = Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $walletId)->first();
        if(is_null($coin)){
            throw new Exception('Amount coin not updated');
        }

        Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $walletId)->update(['amount_coins' => $coin->amount_coins + $amount_coin]);

        $updateCoin = Coin::query()->where('wallet_id', $walletId)->where('coin_id', $coin_id)->first();

        return ($updateCoin->amount_coins !== $coin->amount_coins);


        //DB::update('update coins set amount_coins = amount_coins + "'.$amount_coin.'" where coin_id = "'.$coin_id.'" and wallet_id = "'.$walletId.'" ');
   }

    public function decrementAmountCoinByIdAndWallet(String $coin_id,String $amount_coin, String $walletId):bool{
        if(trim($coin_id) === '' ||trim($amount_coin) === '' || trim($walletId) === '' || $amount_coin <= 0){
            throw new Exception('Amount coin not updated');
        }
        $coin = Coin::query()->where('wallet_id', $walletId)->where('coin_id', $coin_id)->first();
        if(is_null($coin)){
            throw new Exception('Amount coin not updated');
        }
        Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $walletId)->update(['amount_coins' => $coin->amount_coins - $amount_coin]);

        $updateCoin = Coin::query()->where('wallet_id', $walletId)->where('coin_id', $coin_id)->first();
        return ($updateCoin->amount_coins !== $coin->amount_coins);

        //DB::update('update coins set amount_coins = amount_coins - "'.$amount_coin.'" where coin_id = "'.$coin_id.'" and wallet_id = "'.$walletId.'" ');
    }

}
