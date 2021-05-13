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

    public function getWalletWithMaxId():Wallet{
        $wallet = Wallet::query()->orderBy('wallet_id', 'desc')->first();
        if(is_null($wallet) || $wallet->count() == 0){
            throw new Exception('Wallet not found');
        }
        return $wallet;
    }

    public function createNewWalletWithUserId(String $user_id):String{
        if(is_null($user_id) || trim($user_id) === ''){
            throw new Exception('Wallet not created');
        }
        $wallet = Wallet::query()->insertGetId(array('user_id' => $user_id,'transaction_balance' => 0.00));
        return $wallet;
    }

    public function updateTransactionBalanceOfWalletIdWhenIBuy(float $amount_usd, String $wallet_id): bool{
        if(trim($wallet_id) === '' || $amount_usd <= 0){
            throw new Exception('Wallet not updated');
        }
        $wallet = Wallet::query()->where('wallet_id', $wallet_id)->first();
        $before = $wallet->transaction_balance;
        $wallet->update(['transaction_balance' => $wallet->transaction_balance - $amount_usd]);
        return ($wallet->transaction_balance !== $before);
    }

    public function updateTransactionBalanceOfWalletIdWhenISell(float $amount_usd, String $wallet_id): bool{
        if(trim($wallet_id) === '' || $amount_usd <= 0){
            throw new Exception('Wallet not updated');
        }
        $wallet = Wallet::query()->where('wallet_id', $wallet_id)->first();
        $before = $wallet->transaction_balance;
        $wallet->update(['transaction_balance' => $wallet->transaction_balance + $amount_usd]);

        return ($wallet->transaction_balance !== $before);
    }
}
