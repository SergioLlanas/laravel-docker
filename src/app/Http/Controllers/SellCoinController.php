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
            $amount_coin = $request->input("amount_usd");
            if(is_null($coin_id) || is_null($wallet_id) || is_null($amount_coin)){
                return response()->json([
                    'error' => 'Sell not done'
                ], Response::HTTP_BAD_REQUEST);
            }
            if(!$this->sellCoinService->makeSellFunction(floatval($amount_coin), $coin_id, $wallet_id)){
                return response()->json([
                    'error' => 'Sell not done'
                ], Response::HTTP_NOT_FOUND);
            }
        }catch(Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => 'You have sold some coins correctly'
        ], Response::HTTP_OK);
    }
}
