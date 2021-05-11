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

    public function __invoke(String $wallet_id): JsonResponse{
        try{
            $wallet = $this->walletService->find($wallet_id);
            $buyprice = $wallet->buy_price;
            $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=90") ;
            $obj = json_decode($json);
            $actualPrice = $obj[0]->price_usd;
            $balance = $actualPrice - $buyprice;
        }catch(Exception $exception){
            return response()->json([
               'error' => $exception->getMessage()
            ]);
        }
        return response()->json([
            "balance_usd" => $balance
        ], Response::HTTP_OK);
    }
}
