<?php

namespace Tests\Unit\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Models\Coin;
use App\Models\Wallet;
use App\Services\SellCoinService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class SellCoinServiceTest extends TestCase{


    private $coinDataSource;
    private $walletDataSource;
    private $sellCoinService;

    protected function setUp():void{
        parent::setUp();
        $prophet = new Prophet();
        $this->coinDataSource = $prophet->prophesize(CoinDataSource::class);
        $this->walletDataSource = $prophet->prophesize(WalletDataSource::class);
        $this->sellCoinService = new SellCoinService($this->coinDataSource->reveal(), $this->walletDataSource->reveal());
    }

    /** @test */
    public function sellCoinWithOutRequest(){
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => '1', 'user_id' => '25', 'transaction_balance' => 25.99]);
        $coin = new Coin();
        $coin->fill(['id_transaction' => '1', 'coin_id' => '90', 'name' => 'Bitcoin',
            'symbol' => 'BTC', 'wallet_id' => '1', 'amount' => 10, 'value_usd' => 562]);

        $this->coinDataSource->decrementAmountCoinByIdAndWallet('90', 3, '1')->shouldBeCalledOnce()->willReturn(10);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(3, '1')->shouldBeCalledOnce()->willReturn(true);

        $sellCoinService = $this->sellCoinService->makeSellFunction(3, '90', '1');

        $this->assertTrue($sellCoinService);
        /*

        $this->walletDataSource->getWalletById('1')->shouldBeCalledOnce()->willReturn($wallet);
        $this->coinDataSource->makeTransaction(49492.58, 'Bitcoin', 'BTC', '90', '1', 10)->shouldBeCalledOnce()->willReturn(true);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(10,'1')->shouldBeCalledOnce()->willReturn(true);

        $buyCoinService = $this->buyCoinService->checkIfIHaveThisCoin('90', '1', 10);
        $this->assertTrue($buyCoinService);*/
    }

    /** @test */
    /*public function sellCoinWith(){

    }*/

}
