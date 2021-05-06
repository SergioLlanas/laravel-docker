<?php


namespace App\DataSource\database;


use Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\String_;

class WalletDataSource
{

    public function getWalletById(String $id){
        $wallet = DB::table('wallets')->where('wallet_id',$id)->first();
        echo $wallet;
        var_dump($wallet);
        return $wallet;
    }

    public function createNewWalletWithUserId(String $userId){
        DB::insert('insert into wallets (user_id) values ('. $userId. ')');
    }

    public function getWalletWithMaxId(){
        return DB::table('wallets')->max('wallet_id');
    }
}
