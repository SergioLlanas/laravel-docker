<?php


namespace App\Http\Controllers;


use App\DataSource\database\WalletDatabaseAccessObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class OpenWalletController extends BaseController {
    /**
     * @var WalletDatabaseAccessObject
     */
    private $walletDAO;


    /**
     * OpenWalletController constructor.
     */
    public function __construct(WalletDatabaseAccessObject $walletDAO){

        $this->walletDAO = $walletDAO;

    }

    public function __invoke(Request $request): JsonResponse{

       $userId = $request->input("user_id");
       $this->walletDAO->createNewWalletWithUserId($userId);
       $walletWithMaxId = $this->walletDAO->getWalletWithMaxId();


        return response()->json([
            'wallet_id' => $walletWithMaxId
        ], Response::HTTP_OK);
        // TODO: Implement __invoke() method.
    }
}
