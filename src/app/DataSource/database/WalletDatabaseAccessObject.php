<?php


namespace App\DataSource\database;


use Illuminate\Support\Facades\DB;

class WalletDatabaseAccessObject
{

    public function getWalletById(String $id){
        return DB::table('wallets')->where('wallet_id',$id)->first();
    }
}
