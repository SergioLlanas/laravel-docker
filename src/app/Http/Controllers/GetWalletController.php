<?php


namespace App\Http\Controllers;


use App\Service\GetCoinService;
use App\Service\GetWalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class GetWalletController extends BaseController
{

    private $walletService;
    private $coinService;

    /**
     * GetWalletController constructor.
     */
    public function __construct(GetWalletService $walletService, GetCoinService $coinService)
    {
        $this->walletService = $walletService;
        $this->coinService = $coinService;
    }

    public function __invoke(String $idWallet): JsonResponse{

       $wallet = $this->walletService->execute($idWallet);
       $coinName = $this->coinService->getCoinName($wallet->coin_id);
       $coinSymbol = $this->coinService->getCoinSymbol($wallet->coin_id);
        return response()->json([
            'coin_id' => $wallet->coin_id,
            'name' => $coinName,
            'symbol' => $coinSymbol,
            'amount' => $wallet->amount_coins,
            'value_usd' => $wallet->buy_price
        ], Response::HTTP_OK);
    }
}
