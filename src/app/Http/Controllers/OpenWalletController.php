<?php


namespace App\Http\Controllers;


use App\DataSource\database\WalletDataSource;
use App\Services\GetWalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Mockery\Exception;

class OpenWalletController extends BaseController {
    /**
     * @var WalletDataSource
     */
    private $getWalletService;


    /**
     * OpenWalletController constructor.
     */
    public function __construct(GetWalletService $getWalletService){
        $this->getWalletService = $getWalletService;
    }

    public function __invoke(Request $request): JsonResponse{
        try{
            $userId = $request->input("user_id");
            if(is_null($userId)){
                return response()->json([
                    'error' => 'User not found'
                ], Response::HTTP_BAD_REQUEST);
            }
            $wallet = $this->getWalletService->open($userId);
            if(is_null($wallet)){
                return response()->json([
                    'error' => 'Wallet not found'
                ], Response::HTTP_NOT_FOUND);
            }
        }catch(Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'wallet' => $wallet
        ], Response::HTTP_OK);
    }
}
