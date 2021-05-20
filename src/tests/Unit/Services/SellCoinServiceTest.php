<?php

namespace Tests\Unit\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Models\Coin;
use App\Models\Wallet;
use App\Services\SellCoinService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class SellCoinServiceTest extends TestCase{

    use RefreshDatabase;

    private $coinDataSource;
    private $walletDataSource;
    private $sellCoinService;

    protected function setUp():void{
        parent::setUp();
        $prophet = new Prophet();
        $this->coinDataSource = $prophet->prophesize(CoinDataSource::class);
        $this->walletDataSource = $prophet->prophesize(WalletDataSource::class);

        $this->sellCoinService = new SellCoinService($this->coinDataSource->reveal(), $this->walletDataSource->reveal());

        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => '1', 'user_id' => '25', 'transaction_balance' => 25.99]);
        $coin = new Coin();
        $coin->fill(['id_transaction' => '1', 'coin_id' => '90', 'name' => 'Bitcoin',
            'symbol' => 'BTC', 'wallet_id' => '1', 'amount' => 10, 'value_usd' => 562]);
    }

    /** @test */
    public function sellCoinWithCorrectParameters(){
        $this->coinDataSource->getAmountCoinByIdAndWallet('90', '1')->shouldBeCalledOnce()->willReturn(10);
        $this->coinDataSource->decrementAmountCoinByIdAndWallet('90', 3, '1')->shouldBeCalledOnce()->willReturn(true);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(3, '1')->shouldBeCalledOnce()->willReturn(true);
        $isSellDone = $this->sellCoinService->makeSellFunction(3, '90', '1');

        $this->assertTrue($isSellDone);
    }

    /** @test */
    public function sellCoinWithCoinIdIDontHave(){
        $this->coinDataSource->getAmountCoinByIdAndWallet('80', '1')->shouldBeCalledOnce()->willReturn('Coin not found');
        $this->coinDataSource->decrementAmountCoinByIdAndWallet('80', 3, '1')->shouldNotHaveBeenCalled()->willReturn(true);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(3, '1')->shouldNotHaveBeenCalled()->willReturn(true);
        $isSellDone = $this->sellCoinService->makeSellFunction(3, '80', '1');

        $this->assertFalse($isSellDone);
    }

    /** @test */
    public function sellCoinWithWrongWalletId(){
        $this->coinDataSource->getAmountCoinByIdAndWallet('90', '2')->shouldBeCalledOnce()->willReturn('Coin not found');
        $this->coinDataSource->decrementAmountCoinByIdAndWallet('90', 3, '2')->shouldNotHaveBeenCalled()->willReturn(true);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(3, '2')->shouldNotHaveBeenCalled()->willReturn(true);
        $isSellDone = $this->sellCoinService->makeSellFunction(3, '90', '2');

        $this->assertFalse($isSellDone);
    }

    /** @test */
    public function sellMoreThanIHave(){
        $this->coinDataSource->getAmountCoinByIdAndWallet('90', '1')->shouldBeCalledOnce()->willReturn(10);
        $this->coinDataSource->decrementAmountCoinByIdAndWallet('90', 15, '1')->shouldNotHaveBeenCalled()->willReturn(true);
        $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(10, '1')->shouldNotHaveBeenCalled()->willReturn(true);
        $isSellDone = $this->sellCoinService->makeSellFunction(15, '90', '1');

        $this->assertFalse($isSellDone);
    }
}
