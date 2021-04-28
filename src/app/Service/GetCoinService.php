<?php


namespace App\Service;


use App\DataSource\database\CoinDatabaseAccessObject;

class GetCoinService{

    private $coinDAO;

    /**
     * GetCoinService constructor.
     */
    public function __construct(CoinDatabaseAccessObject $coinDAO){
        $this->coinDAO = $coinDAO;

    }
    public function getCoinName(String $coinId):String{
        $coinName = $this->coinDAO->getCoinNameById($coinId);
        if($coinName == null){
            throw new \Exception('Coin not found');
        }
        return $coinName;
    }

    public function getCoinSymbol(String $coinId):String{
        $coinSymb = $this->coinDAO->getCoinSymbolById($coinId);
        if($coinSymb == null){
            throw new \Exception('Coin not found');
        }
        return $coinSymb;
    }
}
