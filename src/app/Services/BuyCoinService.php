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

    public function checkIfIHaveThisCoin(String $coin_id, String $wallet_id, Float $amount_usd): bool{
        try{
            $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin_id);
            $obj = json_decode($json);
            $buyPrice = $obj[0]->price_usd;
            $name = $obj[0]->name;
            $symbol = $obj[0]->symbol;

            try{
                $this->coinDataSource->getAmountCoinByIdAndWallet($coin_id, $wallet_id);
                if($this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy($amount_usd,$wallet_id)){
                    return $this->coinDataSource->incrementAmountCoinByIdAndWallet($coin_id,$amount_usd/floatval($buyPrice),$wallet_id);
                }
            }catch (Exception $exception){
                if($this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy($amount_usd,$wallet_id)){
                    return $this->coinDataSource->doNewTransaction($coin_id,$wallet_id,$amount_usd,$name,$symbol,$buyPrice);
                }
            }
        }catch (Exception $exception){
            throw new Exception("Buy error");
        }
        return true;
    }
}
