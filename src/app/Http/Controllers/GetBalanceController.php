<?php


namespace App\Http\Controllers;


use App\Services\GetWalletService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetBalanceController extends BaseController {

    private $walletService;

    /**
     * GetWalletController constructor.
     */
    public function __construct(GetWalletService $walletService){
        $this->walletService = $walletService;
    }

    public function __invoke(String $idWallet): JsonResponse{
        $amountUsdCoinsIHave = 0;
        $totalBalance = 0;
        try{
            if(is_null($idWallet) || trim($idWallet) == ''){
                return response()->json([
                    'error' => 'Wallet not found'
                ], Response::HTTP_BAD_REQUEST);
            }

            $walletCoins = $this->walletService->getWalletCoins($idWallet)->get();
            for($i = 0; $i < $walletCoins->count(); $i++){
                $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$walletCoins[0]->coin_id);
                $obj = json_decode($json);
                $actualPrice = $obj[0]->price_usd;
                $amountUsdCoin = $walletCoins[0]->amount_coins * $actualPrice;
                $amountUsdCoinsIHave = $amountUsdCoinsIHave + $amountUsdCoin;
            }

            /*foreach ($walletCoins as $coin){
                $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin->coin_id);
                $obj = json_decode($json);
                $actualPrice = $obj[0]->price_usd;
                $amountUsdCoin = $coin->amount_coins * $actualPrice;
                $amountUsdCoinsIHave = $amountUsdCoinsIHave + $amountUsdCoin;
            }*/

            $wallet = $this->walletService->find($idWallet);
            //print_r($wallet->transaction_balance);
            //print_r($amountUsdCoinsIHave);
            $totalBalance = $wallet->transaction_balance + $amountUsdCoinsIHave;
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'balance_usd' => $totalBalance
        ], Response::HTTP_OK);
    }
}
