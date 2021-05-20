<?php

namespace App\Http\Controllers;

use App\Services\BuyCoinService;
use App\Services\GetCoinService;
use App\Services\GetWalletService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class BuyCoinController extends BaseController{

    private $buyService;

    public function __construct(BuyCoinService $buyService){
        $this->buyService = $buyService;
    }

    public function __invoke(Request $request):JsonResponse{
        try{
            $coin_id = $request->input("coin_id");
            $wallet_id = $request->input("wallet_id");
            $amount_usd = $request->input("amount_usd");
            if(trim($coin_id) == '' || trim($wallet_id) == '' || trim($amount_usd) == ''){
                return response()->json([
                    'error' =>'Coin and wallet not found'
                ], Response::HTTP_BAD_REQUEST);
            }
            if(!$this->buyService->checkIfIHaveThisCoin($coin_id, $wallet_id, $amount_usd)){
                return response()->json([
                   'error' => 'Coin not found'
                ], Response::HTTP_NOT_FOUND);
            }
        }catch(Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'success' => 'You have bought some coins correctly'
        ], Response::HTTP_OK);
    }
}
