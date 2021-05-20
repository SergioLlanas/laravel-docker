<?php

namespace App\DataSource\Database;

use App\Models\Wallet;
use Exception;

class WalletDataSource{

    public function getWalletById(String $wallet_id): Wallet{
        $wallet = Wallet::query()->where('wallet_id', $wallet_id)->first();
        if (is_null($wallet) || $wallet->count() == 0) {
            throw new Exception('Wallet not found');
        }
        return $wallet;
    }

    public function createNewWalletWithUserId(String $user_id):String{
        if(is_null($user_id) || trim($user_id) === ''){
            throw new Exception('User was not found');
        }

        $wallet_id = Wallet::query()->insertGetId(array('user_id' => $user_id,'transaction_balance' => 0.00));
        if(is_null($wallet_id)){
            throw new Exception('Wallet not created');
        }
        return $wallet_id;
    }

    public function updateTransactionBalanceOfWalletIdWhenIBuy(float $amount_usd, String $wallet_id): bool{
        /*if(trim($wallet_id) === '' || $amount_usd <= 0){
            throw new Exception('Wallet not updated');
        }*/

        if(trim($wallet_id) === ''){
            throw new Exception('Empty Wallet field');
        }elseif ($amount_usd <=0){
            throw new Exception('Amount_usd have to be positive');
        }

        $wallet = Wallet::query()->where('wallet_id', $wallet_id)->first();
        $before = $wallet->transaction_balance;
        $wallet->update(['transaction_balance' => $wallet->transaction_balance - $amount_usd]);
        return ($wallet->transaction_balance !== $before);
    }

    public function updateTransactionBalanceOfWalletIdWhenISell(float $amount_usd, String $wallet_id): bool{
        /*if(trim($wallet_id) === '' || $amount_usd <= 0){
            throw new Exception('Wallet not updated');
        }*/

        if(trim($wallet_id) === ''){
            throw new Exception('Empty Wallet field');
        }elseif ($amount_usd <=0){
            throw new Exception('Amount_usd have to be positive');
        }

        $wallet = Wallet::query()->where('wallet_id', $wallet_id)->first();
        $before = $wallet->transaction_balance;
        $before = floatval($before);
        $wallet->update(['transaction_balance' => $wallet->transaction_balance + $amount_usd]);

        return ($wallet->transaction_balance !== $before);
    }
}
