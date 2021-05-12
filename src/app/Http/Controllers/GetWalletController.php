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
        var_dump($idWallet);
        echo "<br><br><br><br><br><br><br><br>";
        //$walletCoins = $this->walletService->getWalletCoins($idWallet);
        /*try {
            $wallet = $this->walletService->find($idWallet);
        } catch (Exception $exception) {
            return response()->json([
                'errorWallet' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        var_dump($wallet);
        echo "<br><br><br><br><br><br><br><br>";*/
        try{
            $walletCoins = $this->walletService->getWalletCoins($idWallet);
            //print_r($walletCoins);
            //var_dump($walletCoins);
        } catch (Exception $exception) {
            return response()->json([
                'errorGetCoins' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        //$json = null;

        /*$json =file_get_contents("https://api.coinlore.net/api/ticker/?id=".$wallet->$coin_id) ;
        $obj = json_decode($json);
        $sellPrice = $obj[0]->price_usd;*/

        return response()->json([
            'wallet-data' => $walletCoins,
        ], Response::HTTP_OK);

    }
}
