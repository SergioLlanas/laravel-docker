<?php


namespace App\Http\Controllers;


use App\DataSource\database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Services\BuyCoinService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BuyCoinController extends BaseController{

    /**
     * @var CoinDataSource
     */
    private $coinDAO;
    /**
     * @var WalletDataSource
     */
    private $walletDAO;
    /**
     * @var BuyCoinService
     */
    private $buyService;


    /**
     * BuyCoinController constructor.
     */
    public function __construct(CoinDataSource $coinDAO,WalletDataSource $walletDAO,BuyCoinService $buyService){
        $this->coinDAO = $coinDAO;
        $this->walletDAO = $walletDAO;
        $this->buyService = $buyService;
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

        if(!$this->buyService->checkIfIHaveThisCoin($coin_id)){
            $this->walletDAO->updateTransactionBalanceOfWalletIdWhenIBuy($amount_usd,$wallet_id);
            $this->coinDAO->doNewTransaction($coin_id,$wallet_id,$amount_usd,$name,$symbol,$buyPrice);
        }else{
            $this->walletDAO->updateTransactionBalanceOfWalletIdWhenIBuy($amount_usd,$wallet_id);
            $this->coinDAO->incrementAmountCoinByIdAndWallet($coin_id,$amount_usd/$buyPrice,$wallet_id);
        }



        // TODO: Implement __invoke() method.
    }
}

