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
        /*$wallet = DB::table('wallets')->where('wallet_id',$id)->first();
        echo $wallet;
        var_dump($wallet);
        return $wallet;*/
    }

    public function createNewWalletWithUserId(String $userId){
        DB::insert('insert into wallets (user_id) values ('. $userId. ')');
    }

    public function getWalletWithMaxId(){
        return DB::table('wallets')->max('wallet_id');
    }
}
