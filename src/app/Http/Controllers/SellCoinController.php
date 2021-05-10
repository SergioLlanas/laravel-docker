<?php


namespace App\Http\Controllers;


use App\DataSource\Database\CoinDataSource;
use App\Services\SellCoinService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SellCoinController extends BaseController{

    /**
     * @var CoinDataSource
     */
    private $sellCoinService;


    /**
     * BuyCoinController constructor.
     */
    public function __construct(SellCoinService $sellCoinService){
        $this->sellCoinService = $sellCoinService;
    }

    public function __invoke(Request $request){
        $coinDAO = new CoinDataSource();
        $coin_id = $request->input("coin_id");
        $wallet_id = $request->input("wallet_id");
        $amount_coinString = $request->input("amount_coin");
        $amount_coin = doubleval($amount_coinString);
        $amount_coinIHave = $coinDAO->getAmountCoinByIdAndWallet($coin_id,$wallet_id);
        $newAmount = $amount_coinIHave - $amount_coin;

       // $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin_id) ;
        //$obj = json_decode($json);

        if($this->sellCoinService->getDiferenceBetweenAmountCoinThatIHaveAndAmounCoinIWantToSell($amount_coin,$coin_id,$wallet_id)){
            $coinDAO->updateAmountCoinById($coin_id,$newAmount,$wallet_id);
            echo "Hola se supone que he hecho la transaccion";
        }else{
            echo "Error en la transaccion";
        }


        // TODO: Implement __invoke() method.
    }

}
