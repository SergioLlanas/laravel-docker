<?php

namespace App\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use Doctrine\DBAL\Exception;

class BuyCoinService{

    private $coinDataSource;
    private $walletDataSource;

    public function __construct(CoinDataSource $coinDataSource, WalletDataSource $walletDataSource){
        $this->coinDataSource = $coinDataSource;
        $this->walletDataSource = $walletDataSource;
    }

    public function checkIfIHaveThisCoin(String $coin_id, String $wallet_id, float $amount_usd){
        try{
            $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin_id);
            $obj = json_decode($json);
            if(is_null($obj)){
                throw new Exception('Coin not found');
            }
            $buyPrice = $obj[0]->price_usd;
            $name = $obj[0]->name;
            $symbol = $obj[0]->symbol;
            $wallet = $this->walletDataSource->getWalletById($wallet_id);
            if(!is_null($wallet->wallet_id)){
                if($this->coinDataSource->makeBuyTransaction($buyPrice, $name, $symbol,$coin_id, $wallet_id, $amount_usd)){
                    return $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy($amount_usd, $wallet_id);
                }
            }
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
        return false;
    }
}
