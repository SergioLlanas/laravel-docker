<?php

namespace App\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Models\Wallet;
use Exception;

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
        try{
            $walletId = $this->walletDataSource->createNewWalletWithUserId($user_id);
            $wallet = $this->walletDataSource->getWalletById($walletId);
        }catch (Exception $exception){
            throw new Exception ($exception->getMessage());
        }
        return $wallet;
    }

    public function find(String $wallet_id):Wallet{
        $wallet = $this->walletDataSource->getWalletById($wallet_id);
        if($wallet == null || $wallet->getAttributes() == "[]"){
            throw new Exception('Wallet with specific Id not found');
        }
        return $wallet;
    }

    /* CUIDADO CON ESTO QUE DEPENDE DE LA FUNCION PETA O NO */
    public function getWalletCoins(String $wallet_id){
       $coins = $this->coinDataSource->getCoinsByWalletId($wallet_id);
       if($coins == null){
           throw new Exception('Coins not found');
       }
       return $coins;
    }
}
