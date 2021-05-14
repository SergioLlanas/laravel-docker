<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model{

    use HasFactory;

    protected $fillable = ['id_transaction', 'coin_id', 'name', 'symbol', 'wallet_id', 'amount', 'value_usd'];

}
