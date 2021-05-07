<?php

namespace App\Services;

use App\DataSource\database\WalletDataSource;

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

    public function execute(String $id){
        $wallet = $this->walletDataSource->getWalletById($id);
        if($wallet == null){
            throw new \Exception('Wallet not found');
        }
        return $wallet;
    }
}
