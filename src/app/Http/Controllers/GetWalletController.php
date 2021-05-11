<?php


namespace App\Http\Controllers;

use Exception;
use App\Services\GetCoinService;
use App\Services\GetWalletService;
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

        try {
            $wallet = $this->walletService->find($idWallet);
        } catch (Exception $exception) {
            return response()->json([
                'errorWallet' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        try{
            $coinName = $this->coinService->getCoinName($wallet->coin_id);
        } catch (Exception $exception) {
            return response()->json([
                'errorCoinName' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        try{
            $coinSymbol = $this->coinService->getCoinSymbol($wallet->coin_id);
        } catch (Exception $exception) {
            return response()->json([
                'errorCoinSymbol' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'coin_id' => $wallet->coin_id,
            'name' => $coinName,
            'symbol' => $coinSymbol,
            'amount' => $wallet->amount_coins,
            'value_usd' => $wallet->buy_price
        ], Response::HTTP_OK);


       /*$wallet = $this->walletService->execute($idWallet);
       $coinName = $this->coinService->getCoinName($wallet->coin_id);
       $coinSymbol = $this->coinService->getCoinSymbol($wallet->coin_id);*/
        /*return response()->json([
            'coin_id' => $wallet->coin_id,
            'name' => $coinName,
            'symbol' => $coinSymbol,
            'amount' => $wallet->amount_coins,
            'value_usd' => $wallet->buy_price
        ], Response::HTTP_OK);*/
    }
}
