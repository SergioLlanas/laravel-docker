<?php


namespace App\Services;


use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use PhpParser\Node\Expr\Cast\Double;

class SellCoinService{


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



    public function getDiferenceBetweenAmountCoinThatIHaveAndAmounCoinIWantToSell(float $amount_coin,String $coin_id,String $walletId){
        $coinDAO = new CoinDataSource();
        $amount_coinIHave = $coinDAO->getAmountCoinByIdAndWallet($coin_id,$walletId);
        $difference = $amount_coinIHave - $amount_coin;

        if($difference < 0){
            return false;
        }
        return true;
    }

    public function getUSDWhenISell($amount_coin,$coin_id): float{
        $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin_id) ;
        $obj = json_decode($json);
        $sellPrice = $obj[0]->price_usd;
        return $amount_coin * $sellPrice;
    }

}
