<?php

namespace App\Services;

use App\DataSource\Database\WalletDataSource;
use App\Models\Wallet;

class GetWalletService{
    /**
     * @var WalletDataSource
     */
    private $walletDataSource;

    /**
     * GetWalletService constructor.
     */
    public function __construct(WalletDataSource $walletDataSource){
        $this->walletDataSource = $walletDataSource;
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

    /*public function execute(String $id):Wallet{
        $wallet = $this->walletDataSource->getWalletById($id);
        if($wallet == null){
            throw new \Exception('Wallet not found');
        }
        return $wallet;
    }*/
}
