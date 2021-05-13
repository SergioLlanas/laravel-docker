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

    public function __invoke(String $idWallet): JsonResponse{

        try{
            $walletCoins = $this->walletService->getWalletCoins($idWallet);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'wallet-data' => $walletCoins,
        ], Response::HTTP_OK);

    }
}
