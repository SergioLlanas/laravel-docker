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

}
