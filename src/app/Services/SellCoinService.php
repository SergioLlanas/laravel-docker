<?php


namespace App\Services;


use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use PhpParser\Node\Expr\Cast\Double;

class SellCoinService{

    private $coinDataSource;

    /**
     * SellCoinService constructor.
     */
    public function __construct(CoinDataSource $coinDataSource){
        $this->coinDataSource = $coinDataSource;
    }

    public function getDiferenceBetweenAmountCoinThatIHaveAndAmounCoinIWantToSell(float $amount_coin,String $coin_id,String $wallet_id){
        $amount_coinIHave = $this->coinDataSource->getAmountCoinByIdAndWallet($coin_id,$wallet_id);
        $difference = $amount_coinIHave - $amount_coin;
        return ($difference >=0);
    }

    public function getUSDWhenISell(float $amount_coin, String $coin_id): float{
        $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin_id) ;
        $obj = json_decode($json);
        $sellPrice = $obj[0]->price_usd;
        return $amount_coin * $sellPrice;
    }

}
