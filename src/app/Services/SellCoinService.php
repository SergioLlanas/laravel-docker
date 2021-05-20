<?php

namespace App\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use Doctrine\DBAL\Exception;
use PhpParser\Node\Expr\Cast\Double;

class SellCoinService{

    private $coinDataSource;
    private $walletDataSource;

    /**
     * SellCoinService constructor.
     */
    public function __construct(CoinDataSource $coinDataSource, WalletDataSource $walletDataSource){
        $this->coinDataSource = $coinDataSource;
        $this->walletDataSource = $walletDataSource;
    }

    public function makeSellFunction(float $amount, String $coin_id, String $wallet_id){
        try{
            $amountCoin = $this->coinDataSource->getAmountCoinByIdAndWallet($coin_id, $wallet_id);
            $amountCoin = floatval($amountCoin);
            $difference = $amountCoin - $amount;
            if($difference > 0){
                if($this->coinDataSource->decrementAmountCoinByIdAndWallet($coin_id, $amount, $wallet_id)){
                    return $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell($amount, $wallet_id);
                }
            }
        }catch(Exception $exception){
            throw new Exception($exception->getMessage());
        }
        return false;
    }
}
