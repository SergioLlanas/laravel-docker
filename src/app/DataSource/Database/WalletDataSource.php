<?php


namespace App\DataSource\Database;

use App\Models\Wallet;
use Exception;
use Illuminate\Http\Request;
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

    public function getWalletWithMaxId():Wallet{
        $wallet = Wallet::orderBy('wallet_id', 'desc')->first();
            if(is_null($wallet)){
                throw new Exception('Wallet not found');
            }
        return $wallet;
    }

    public function createNewWalletWithUserId(String $user_id){
        Wallet::query()->insert(array('user_id' => $user_id));

        //DB::insert('insert into wallets (user_id) values (?)',[$user_id]);
        //DB::commit();
        //DB::insert('insert into wallets (user_id) values ('. $userId. ')');
    }
}
