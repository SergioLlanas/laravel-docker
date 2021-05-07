<?php


namespace App\DataSource\Database;

use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;

class WalletDataSource
{

    public function getWalletById(String $wallet_id): Wallet{
        $wallet = Wallet::query()->where('wallet_id', $wallet_id)->first();
        if (is_null($wallet)) {
            throw new Exception('Wallet not found');
        }
        return $wallet;
    }

    public function createNewWalletWithUserId(String $userId){
        DB::insert('insert into wallets (user_id) values ('. $userId. ')');
    }

    public function getWalletWithMaxId():Wallet{
        $wallet = Wallet::orderBy('wallet_id', 'desc')->first();
            if(is_null($wallet)){
                throw new Exception('Wallet not found');
            }
        return $wallet;
    }
}
