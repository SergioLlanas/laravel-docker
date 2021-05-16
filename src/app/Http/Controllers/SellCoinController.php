<?php


namespace App\Http\Controllers;


use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Services\SellCoinService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function __invoke(Request $request):JsonResponse{
        try{
            $coin_id = $request->input("coin_id");
            $wallet_id = $request->input("wallet_id");
            $amount_coin = $request->input("amount_coin");
            if(is_null($coin_id) || is_null($wallet_id) || is_null($amount_coin)){
                return response()->json([
                    'error' => 'Sell not done'
                ], Response::HTTP_BAD_REQUEST);
            }
            if($this->sellCoinService->makeSellFunction(floatval($amount_coin), $coin_id, $wallet_id)){
                return response()->json([
                    'error' => 'Sell not done'
                ], Response::HTTP_NOT_FOUND);
            }
        }catch(Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }


        /*$walletDAO = new WalletDataSource();
        $coinDAO = new CoinDataSource();
        $coin_id = $request->input("coin_id");
        $wallet_id = $request->input("wallet_id");
        $amount_coinString = $request->input("amount_coin");
        $amount_coin = doubleval($amount_coinString);*/

        /*if($this->sellCoinService->getDiferenceBetweenAmountCoinThatIHaveAndAmounCoinIWantToSell($amount_coin,$coin_id,$wallet_id)){
            $coinDAO->decrementAmountCoinByIdAndWallet($coin_id,$amount_coin,$wallet_id);
            $walletDAO->updateTransactionBalanceOfWalletIdWhenISell($this->sellCoinService->getUSDWhenISell($amount_coin,$coin_id),$wallet_id);
        }else{
            echo "Error en la transaccion";
        }*/

    }

}
