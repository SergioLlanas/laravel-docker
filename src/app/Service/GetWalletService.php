<?php


namespace App\Service;


use App\DataSource\database\CoinDatabaseAccessObject;
use App\DataSource\database\WalletDatabaseAccessObject;

class GetWalletService{
    /**
     * @var WalletDatabaseAccessObject
     */
    private $walletDAO;



    /**
     * GetWalletService constructor.
     */
    public function __construct(WalletDatabaseAccessObject $walletDAO){
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
