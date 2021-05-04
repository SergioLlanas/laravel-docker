<?php


namespace App\Http\Controllers;


use App\Service\GetWalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetBalanceController extends BaseController {

    private $walletService;

    /**
     * GetWalletController constructor.
     */
    public function __construct(GetWalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function __invoke(String $idWallet): JsonResponse{
        // TODO: Implement __invoke() method.
        $wallet = $this->walletService->execute($idWallet);
        $buyprice = $wallet->buy_price;
        $json =file_get_contents("https://api.coinlore.net/api/ticker/?id=90") ;
        $obj = json_decode($json);
        $actualPrice = $obj[0]->price_usd;
        $balance = $actualPrice - $buyprice;

        return response()->json([
            "balance_usd" => $balance
        ], Response::HTTP_OK);
    }
}
