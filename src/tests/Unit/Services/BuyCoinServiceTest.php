<?php

namespace Tests\Unit\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Models\Coin;
use App\Models\Wallet;
use App\Services\BuyCoinService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class BuyCoinServiceTest extends TestCase{

    use RefreshDatabase;

    private $coinDataSource;
    private $walletDataSource;
    private $buyCoinService;

    protected function setUp():void{
        parent::setUp();
        $prophet = new Prophet();

        $this->coinDataSource = $prophet->prophesize(CoinDataSource::class);
        $this->walletDataSource = $prophet->prophesize(WalletDataSource::class);

        $this->buyCoinService = new BuyCoinService($this->coinDataSource->reveal(), $this->walletDataSource->reveal());
    }

    /** @test */
    public function testExample(){
        $coin = new Coin();
        $coin->fill(['id_transaction' => '1', 'coin_id' => '1', 'nameCoin' => 'Bitcoin',
            'symbol' => 'BTC', 'wallet_id' => '1', 'amount_coins' => 10]);
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => '1', 'user_id' => '25', 'transaction_balance' => 25.99]);

        //Llama a las funciones: getAmountCoinByIdAndWallet
        $this->coinDataSource->getAmountCoinByIdAndWallet('1', '1')->shouldBeCalledOnce()->willReturn(10);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(10,'1')->shouldBeCalledOnce()->willReturn(true);
        $this->coinDataSource->incrementAmountCoinByIdAndWallet('1', 10, '1')->shouldBeCalledOnce()->willReturn(true);

        $this->coinDataSource->doNewTransaction('1', '1', 25, 'Bitcoin', 'BTC', 200)->shouldNotHaveBeenCalled()->willReturn(true);

        $buyCoinService = $this->buyCoinService->checkIfIHaveThisCoin('1', '1', 10);
        $this->assertTrue($buyCoinService);

    }
}
