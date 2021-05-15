<?php

namespace App\DataSource\Database;

use App\Models\Coin;
use Exception;

class CoinDataSource{

    public function getCoinById(String $coin_id):Coin{
        $coin = Coin::query()->where('coin_id', $coin_id)->first();
        if (is_null($coin) || $coin->count() == 0) {
            throw new Exception('Coin not found');
        }
        return $coin;
    }

    public function getCoinNameById(String $coin_id): String{
        $coin = Coin::query()->where('coin_id', $coin_id)->first();
        if (is_null($coin) || $coin->count() == 0) {
            throw new Exception('Coin not found');
        }
        return $coin->name;
    }

    public function getCoinSymbolById(String $coin_id): String{
        $coin = Coin::query()->where('coin_id', $coin_id)->first();
        if (is_null($coin) || $coin->count() == 0) {
            throw new Exception('Coin not found');
        }
        return $coin->symbol;
    }

    public function getAmountCoinByIdAndWallet(String $coin_id,String $wallet_id):Float{
        $coin = Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $wallet_id)->first();
        if(is_null($coin) || $coin->count() == 0){
            throw new Exception('Coin not found');
        }
        return floatval($coin->amount);
    }

    public function getCoinsByWalletId(String $wallet_id){
        $coins = Coin::query()->where('wallet_id',$wallet_id)->select('coin_id', 'name', 'symbol', 'amount', 'value_usd');
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
            'coin_id' => $coin_id, 'name' => $name, 'symbol' => $symbol,
            'wallet_id' => $wallet_id, 'amount' => $amount_usd/$buy_price,
            'value_usd' => $buy_price
        ));
        return $coin;
   }

    public function incrementAmountCoinByIdAndWallet(String $coin_id, float $amount_coin, String $walletId){
        if(trim($coin_id) === '' || trim($walletId) === '' || $amount_coin <= 0){
            throw new Exception('Amount coin not updated');
        }

        $coin = Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $walletId)->first();
        if(is_null($coin)){
            throw new Exception('Amount coin not updated');
        }
        $before = $coin->amount;
        $coin->update(['amount' => $coin->amount + $amount_coin]);

        return ($coin->amount != $before);
    }

    public function decrementAmountCoinByIdAndWallet(String $coin_id,String $amount_coin, String $walletId):bool{
        if(trim($coin_id) === '' ||trim($amount_coin) === '' || trim($walletId) === '' || $amount_coin <= 0){
            throw new Exception('Amount coin not updated');
        }
        $coin = Coin::query()->where('wallet_id', $walletId)->where('coin_id', $coin_id)->first();
        if(is_null($coin)){
            throw new Exception('Amount coin not updated');
        }

        $before = $coin->amount;
        $coin->update(['amount' => $coin->amount - $amount_coin]);
        return ($coin->amount !== $before);
    }

    public function makeTransaction(string $buyPrice, string $name,string $symbol, string $coin_id, string $wallet_id, float $amount_usd){
        /* Comprobamos si existe la coin en la cartera */
        $coin = Coin::query()->where('coin_id', $coin_id)->where('wallet_id', $wallet_id)->first();

        /* Hacer la transacción */
        if($coin->get()->count() == 0){
            /* No existe */
            return $this->doNewTransaction($coin_id,$wallet_id,$amount_usd,$name,$symbol,$buyPrice);
        }else{
            /* Existe */
            return $this->incrementAmountCoinByIdAndWallet($coin_id,$amount_usd/floatval($buyPrice),$wallet_id);
        }
    }

}
