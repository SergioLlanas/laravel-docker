<?php


namespace App\Services;


use App\DataSource\Database\CoinDataSource;
use PhpParser\Node\Expr\Cast\Double;

class SellCoinService{

    private $coin_id;
    private $amount_coin;

    /**
     * SellCoinService constructor.
     */
    public function __construct()
    {
    }

    /**
     * SellCoinService constructor.
     * @param $coin_id
     * @param Double $amount_coin
     */
    /*public function __construct(CoinDataSource $coin_id,Double $amount_coin)
    {
        $this->coin_id = $coin_id;
        $this->amount_coin = $amount_coin;
    }*/



    public function getDiferenceBetweenAmountCoinThatIHaveAndAmounCoinIWantToSell($amount_coin,$coin_id,$walletId){
        $coinDAO = new CoinDataSource();
        $amount_coinIHave = $coinDAO->getAmountCoinByIdAndWallet($coin_id,$walletId);
        $difference = $amount_coinIHave - $amount_coin;

        if($difference < 0){
            return false;
        }
        return true;
    }

}
