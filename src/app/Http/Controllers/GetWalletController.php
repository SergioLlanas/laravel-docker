<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\GetWalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetWalletController extends BaseController{

    private $walletService;

    /**
     * GetWalletController constructor.
     */
    public function __construct(GetWalletService $walletService){
        $this->walletService = $walletService;
    }

    public function __invoke(String $wallet_id): JsonResponse{
        //Comprobamos si existe o no la cartera. Si no existe se lanza una excepción
        try{
            $this->walletService->find($wallet_id);
        }catch(Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }

        //Luego se buscan las coins. Si no hay coins se lanza una excepción
        try{
            $walletCoins = $this->walletService->getWalletCoins($wallet_id);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'wallet-data' => $walletCoins->get(),
        ], Response::HTTP_OK);
    }
}
