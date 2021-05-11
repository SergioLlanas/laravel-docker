<?php


namespace App\Services;


use App\DataSource\Database\CoinDataSource;

class BuyCoinService{
    /**
     * SellCoinService constructor.
     */
    public function __construct(){
    }

    public function checkIfIHaveThisCoin($coin_id): bool{
        $coinDAO = new CoinDataSource();
        try {
            $coinDAO->getCoinById($coin_id);
            return true;
        } catch (\Exception $e) {
            return false;
        }


    }
}
