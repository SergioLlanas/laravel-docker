<?php


namespace App\Http\Controllers;


use App\DataSource\database\CoinDatabaseAccessObject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BuyCoinController extends BaseController{

    /**
     * @var CoinDatabaseAccessObject
     */
    private $coinDAO;


    /**
     * BuyCoinController constructor.
     */
    public function __construct(CoinDatabaseAccessObject $coinDAO){
        $this->coinDAO = $coinDAO;
    }

    public function __invoke(Request $request){
        $coin_id = $request->input("coin_id");
        $wallet_id = $request->input("wallet_id");
        $amount_usd = $request->input("amount_usd");

        $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin_id) ;
        $obj = json_decode($json);
        $buyPrice = $obj[0]->price_usd;
        $name = $obj[0]->name;
        $symbol = $obj[0]->symbol;

        $this->coinDAO->doNewTransaction($coin_id,$wallet_id,$amount_usd,$name,$symbol,$buyPrice);

        // TODO: Implement __invoke() method.
    }
}

