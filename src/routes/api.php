<?php

use App\Http\Controllers\IsEarlyAdopterUserController;
use App\Http\Controllers\BuyCoinController;
use App\Http\Controllers\GetBalanceController;
use App\Http\Controllers\GetUserController;
use App\Http\Controllers\GetWalletController;
use App\Http\Controllers\OpenWalletController;
use App\Http\Controllers\SellCoinController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get(
    '/status',
    StatusController::class
);

Route::get('user/{email}', IsEarlyAdopterUserController::class);

Route::get(
    '/user/{id}',
    GetUserController::class
);

Route::post(
    '/coin/buy',
    BuyCoinController::class
);

Route::post(
    '/coin/sell',
    SellCoinController::class
);

Route::get(
    '/wallet/{idWallet}',
    GetWalletController::class
);

Route::get(
    '/wallet/{idWallet}/balance',
    GetBalanceController::class
);

Route::post(
    '/wallet/open',
    OpenWalletController::class
);


