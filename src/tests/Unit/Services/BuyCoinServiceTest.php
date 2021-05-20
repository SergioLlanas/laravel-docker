<?php

namespace Tests\Unit\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Models\Coin;
use App\Models\Wallet;
use App\Services\BuyCoinService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class BuyCoinServiceTest extends TestCase{

    use RefreshDatabase;

    private $coinDataSource;
    private $walletDataSource;
    private $buyCoinService;
    private $wallet;

    protected function setUp():void{
        parent::setUp();
        $prophet = new Prophet();

        $this->coinDataSource = $prophet->prophesize(CoinDataSource::class);
        $this->walletDataSource = $prophet->prophesize(WalletDataSource::class);

        $this->buyCoinService = new BuyCoinService($this->coinDataSource->reveal(), $this->walletDataSource->reveal());

        $this->wallet = new Wallet();
        $this->wallet->fill(['wallet_id' => '1', 'user_id' => '25', 'transaction_balance' => 25.99]);
        $coin = new Coin();
        $coin->fill(['id_transaction' => '1', 'coin_id' => '90', 'name' => 'Bitcoin',
            'symbol' => 'BTC', 'wallet_id' => '1', 'amount' => 10, 'value_usd' => 562]);
    }

    /** @test */
    public function buyCoinIdExist(){
        $this->walletDataSource->getWalletById('1')->shouldBeCalledOnce()->willReturn($this->wallet);
        $this->coinDataSource->makeBuyTransaction(39229.28, 'Bitcoin', 'BTC', '90', '1', 10)->shouldBeCalledOnce()->willReturn(true);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(10,'1')->shouldBeCalledOnce()->willReturn(true);
        $buyCoinService = $this->buyCoinService->checkIfIHaveThisCoin('90', '1', 10);

        $this->assertTrue($buyCoinService);
    }

    /** @test */
    public function buyCoinIDontHave(){
        $this->walletDataSource->getWalletById('1')->shouldBeCalledOnce()->willReturn($this->wallet);
        $this->coinDataSource->makeBuyTransaction(2868.48, 'Ethereum', 'ETH', '80', '1', 10)->shouldBeCalledOnce()->willReturn(true);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(10,'1')->shouldBeCalledOnce()->willReturn(true);
        $buyCoinService = $this->buyCoinService->checkIfIHaveThisCoin('80', '1', 10);

        $this->assertTrue($buyCoinService);
    }

    /** @test */
    public function walletNoExist(){
        $this->walletDataSource->getWalletById('2')->shouldBeCalledOnce()->willReturn(new Wallet());
        $this->coinDataSource->makeBuyTransaction(2868.48, 'Ethereum', 'ETH', '80', '2', 10)->shouldNotHaveBeenCalled()->willReturn(true);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(10,'2')->shouldNotHaveBeenCalled()->willReturn(false);
        $buyCoinService = $this->buyCoinService->checkIfIHaveThisCoin('80', '2', 10);

        $this->assertFalse($buyCoinService);
    }
}
