<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\GetWalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use function PHPUnit\Framework\isEmpty;

class GetWalletController extends BaseController{

    private $walletService;

    /**
     * GetWalletController constructor.
     */
    public function __construct(GetWalletService $walletService){
        $this->walletService = $walletService;
    }

    public function __invoke(String $wallet_id): JsonResponse{
        if(trim($wallet_id) == ''){
            return response()->json([
                'error' => 'Wallet not found'
            ], Response::HTTP_BAD_REQUEST);
        }
        try{
            $wallet = $this->walletService->find($wallet_id);
            $walletCoins = $this->walletService->getWalletCoins($wallet_id);
            if($walletCoins->count() <= 0){
                return response()->json([
                    'error' => 'Coin not found'
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'wallet-data' => $walletCoins->get(),
        ], Response::HTTP_OK);
    }
}
