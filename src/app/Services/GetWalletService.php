<?php


namespace App\Services;


use App\DataSource\database\CoinDataSource;
use App\DataSource\database\WalletDataSource;

class GetWalletService{
    /**
     * @var WalletDataSource
     */
    private $walletDAO;



    /**
     * GetWalletService constructor.
     */
    public function __construct(WalletDataSource $walletDAO){
        $this->walletDAO = $walletDAO;
    }

    public function execute(String $id){
        $wallet = $this->walletDAO->getWalletById($id);
        if($wallet == null){
            throw new \Exception('Wallet not found');
        }
        return $wallet;
    }
}
