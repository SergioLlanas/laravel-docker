<?php

namespace App\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Models\Wallet;
use PhpParser\Node\Scalar\String_;

class GetWalletService{

    /**
     * @var WalletDataSource
     */
    private $walletDataSource;
    /**
     * @var CoinDataSource
     */
    private $coinDataSource;

    /**
     * GetWalletService constructor.
     */
    public function __construct(WalletDataSource $walletDataSource, CoinDataSource $coinDataSource){
        $this->walletDataSource = $walletDataSource;
        $this->coinDataSource = $coinDataSource;
    }

    public function open(String $user_id):Wallet{
        /* Crearlo y que directamente me devuelva el id */
        $this->walletDataSource->createNewWalletWithUserId($user_id);
        $wallet = $this->walletDataSource->getWalletWithMaxId();
        if($wallet == null){
            throw new \Exception('Wallet not created');
        }
        return $wallet;
    }

    public function find(String $wallet_id):Wallet{
        $wallet = $this->walletDataSource->getWalletById($wallet_id);
        if($wallet == null){
            throw new \Exception('Wallet not found');
        }
        return $wallet;
    }

    public function getWalletCoins(String $wallet_id){
       $coins = $this->coinDataSource->getCoinsByWalletId($wallet_id);
       if($coins == null){
           throw new \Exception('Coins not found');
       }
       return $coins;
    }
}
