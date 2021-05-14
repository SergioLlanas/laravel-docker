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
        }catch(Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'wallet_id' => $wallet->wallet_id
        ], Response::HTTP_OK);
    }
}
