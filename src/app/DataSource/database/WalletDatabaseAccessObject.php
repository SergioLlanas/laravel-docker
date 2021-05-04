<?php


namespace App\DataSource\database;


use Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\String_;

class WalletDatabaseAccessObject
{

    public function getWalletById(String $id){
        return DB::table('wallets')->where('wallet_id',$id)->first();
    }

    public function createNewWalletWithUserId(String $userId){
        DB::insert('insert into wallets (user_id) values (?)', $userId);
    }
}
