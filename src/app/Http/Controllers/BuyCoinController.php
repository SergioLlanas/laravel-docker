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

    public function __invoke(Request $request):Response{
        /*
         * try{
            $userId = $request->input("user_id");
            if(is_null($userId)){
                return response()->json([
                    'error' => 'User not found'
                ], Response::HTTP_BAD_REQUEST);
            }
            $wallet = $this->getWalletService->open($userId);
        }catch(Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'wallet_id' => $wallet
        ], Response::HTTP_OK);
         */

        $coin_id = $request->input("coin_id");
        $wallet_id = $request->input("wallet_id");
        $amount_usd = doubleval($request->input("amount_usd"));
        if(is_null($coin_id) || is_null($wallet_id)){
            throw new Exception('Empty parameters');
        }
        if(!$this->buyService->checkIfIHaveThisCoin($coin_id, $wallet_id,$amount_usd)){
            throw new Exception('Buy error');
        }

        return response()->setContent(Response::HTTP_OK);

    }
}

