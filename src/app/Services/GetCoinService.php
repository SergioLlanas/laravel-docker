<?php

namespace App\Services;

use App\DataSource\Database\CoinDataSource;
use Exception;

class GetCoinService{

    private $coinDataSource;

    /**
     * GetCoinService constructor.
     */
    public function __construct(CoinDataSource $coinDataSource){
        $this->coinDataSource = $coinDataSource;
    }

    public function getCoinName(String $coinId):String{
        $coinName = $this->coinDataSource->getCoinNameById($coinId);
        if($coinName == null){
            throw new Exception('Coin not found', 404);
        }
        return $coinName;
    }
}
