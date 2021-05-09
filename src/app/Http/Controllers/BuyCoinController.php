<?php


namespace App\Http\Controllers;


use App\DataSource\database\CoinDataSource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BuyCoinController extends BaseController{

    /**
     * @var CoinDataSource
     */
    private $coinDAO;


    /**
     * BuyCoinController constructor.
     */
    public function __construct(CoinDataSource $coinDAO){
        $this->coinDAO = $coinDAO;
    }

    public function __invoke(Request $request){
        $coin_id = $request->input("coin_id");
        $wallet_id = $request->input("wallet_id");
        $amount_usdString = $request->input("amount_usd");
        $amount_usd = doubleval($amount_usdString);

        $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin_id) ;
        $obj = json_decode($json);
        $buyPrice = $obj[0]->price_usd;
        $name = $obj[0]->name;
        $symbol = $obj[0]->symbol;

        $this->coinDAO->doNewTransaction($coin_id,$wallet_id,$amount_usd,$name,$symbol,$buyPrice);

        // TODO: Implement __invoke() method.
    }
}

