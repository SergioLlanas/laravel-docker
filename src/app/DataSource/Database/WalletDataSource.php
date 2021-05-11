<?php


namespace App\DataSource\Database;

use App\Models\Wallet;
use Exception;

class WalletDataSource
{

    public function getWalletById(String $wallet_id): Wallet{
        $wallet = Wallet::query()->where('wallet_id', $wallet_id)->first();
        if (is_null($wallet)) {
            throw new Exception('Wallet not found');
        }
        return $wallet;
    }

    public function getWalletWithMaxId():Wallet{
        $wallet = Wallet::query()->orderBy('wallet_id', 'desc')->first();
        if(is_null($wallet)){
            throw new Exception('Wallet not found');
        }
        return $wallet;
    }

    public function createNewWalletWithUserId(String $user_id){
        $wallet = Wallet::query()->insert(array('user_id' => $user_id,'transaction_balance' => 0.00));
        return $wallet;
    }
}
