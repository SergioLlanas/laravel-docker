<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model{

    use HasFactory;

    protected $fillable = ['coin_id', 'nameCoin', 'symbol', 'wallet_id', 'buy_price', 'amount_coins'];

}
