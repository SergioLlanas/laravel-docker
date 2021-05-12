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
            $walletCoins = $this->walletService->getWalletCoins($idWallet);
            //print_r($walletCoins);
            //var_dump($walletCoins);
        } catch (Exception $exception) {
            return response()->json([
                'errorGetCoins' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        foreach ($walletCoins as $coin){
            $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$coin->coin_id) ;
            $obj = json_decode($json);
            $actualPrice = $obj[0]->price_usd;
            $amountUsdCoin = $coin->amount_coins * $actualPrice;
            $amountUsdCoinsIHave = $amountUsdCoinsIHave + $amountUsdCoin;
        }

        $wallet = $this->walletService->find($idWallet);
        $totalBalance = $wallet->transaction_balance + $amountUsdCoinsIHave;

        return response()->json([
            "balance_usd" => $totalBalance
        ], Response::HTTP_OK);
    }
}
