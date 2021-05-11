<?php


namespace App\Http\Controllers;


use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
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
        $walletDAO = new WalletDataSource();
        $coinDAO = new CoinDataSource();
        $coin_id = $request->input("coin_id");
        var_dump($coin_id);
        $wallet_id = $request->input("wallet_id");
        var_dump($wallet_id);
        $amount_coinString = $request->input("amount_coin");
        var_dump($amount_coinString);
        $amount_coin = doubleval($amount_coinString);
        $amount_coinIHave = $coinDAO->getAmountCoinByIdAndWallet($coin_id,$wallet_id);
        $newAmount = $amount_coinIHave - $amount_coin;


        if($this->sellCoinService->getDiferenceBetweenAmountCoinThatIHaveAndAmounCoinIWantToSell($amount_coin,$coin_id,$wallet_id)){
            $coinDAO->decrementAmountCoinByIdAndWallet($coin_id,$newAmount,$wallet_id);
            $walletDAO->updateTransactionBalanceOfWalletIdWhenISell($amount_usd,$wallet_id);
        }else{
            echo "Error en la transaccion";
        }


        // TODO: Implement __invoke() method.
    }

}
