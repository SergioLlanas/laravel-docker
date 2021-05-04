<?php


namespace App\DataSource\database;


use Illuminate\Support\Facades\DB;

class CoinDatabaseAccessObject{

    public function getCoinById(String $id){
        return DB::table('coins')->where('coin_id',$id)->first();
    }

    public function getCoinNameById(String $id): String{
        $coin = $this->getCoinById($id);
        return $coin->name;
    }

    public function getCoinSymbolById(String $id): String{
        $coin = $this->getCoinById($id);
        return $coin->symbol;
    }

    public function getWalletWithMaxId(){
        return DB::select("select * from wallets where wallet_id = max(wallet_id)");
    }

}
