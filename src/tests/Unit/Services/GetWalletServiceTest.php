<?php

namespace Tests\Unit\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Models\Coin;
use App\Models\Wallet;
use App\Services\GetWalletService;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class GetWalletServiceTest extends TestCase{

    private $walletDataSource;
    private $walletService;
    private $coinDataSource;

    protected function setUp(): void{
        parent::setUp();
        $prophet = new Prophet();
        $this->walletDataSource = $prophet->prophesize(WalletDataSource::class);
        $this->coinDataSource = $prophet->prophesize(CoinDataSource::class);
        $this->walletService = new GetWalletService($this->walletDataSource->reveal(), $this->coinDataSource->reveal());
    }

    /** @test */
    public function openNewWalletWithUserId(){
        $wallet_id = '1';
        $user_id = '2';
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => $wallet_id, 'user_id' => $user_id, 'transaction_balance' => 0.00]);

        $this->walletDataSource->getWalletById($wallet_id)->shouldBeCalledOnce()->willReturn($wallet);
        $this->walletDataSource->createNewWalletWithUserId($user_id)->shouldBeCalledOnce()->willReturn($wallet_id);
        $isWallet = $this->walletService->open($user_id);

        $this->assertInstanceOf(Wallet::class, $isWallet);
    }

    /** @test */
    public function getExistingWalletById(){
        $wallet_id = '1';
        $user_id = '1';
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => $wallet_id, 'user_id' => $user_id, 'transaction_balance' => 15]);

        $this->walletDataSource->getWalletById($wallet_id)->shouldBeCalledOnce()->willReturn($wallet);
        $isWallet = $this->walletService->find($wallet_id);

        $this->assertInstanceOf(Wallet::class, $isWallet);
    }

    /** @test */
    public function getAllTheCoinsOfAWallet(){
        $wallet_id = '1';
        $user_id = '1';
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => $wallet_id, 'user_id' => $user_id, 'transaction_balance' => 15]);
        $coin = new Coin();
        $coin->fill(['id_transaction' => 1, 'coin_id' => '1', 'name' => 'Bitcoin',
            'symbol' => 'BTC', 'wallet_id' => $wallet_id, 'amount' => 10, 'value_usd' => 10]);

        $this->coinDataSource->getCoinsByWalletId($wallet_id)->shouldBeCalledOnce()->willReturn($coin);
        $isCoin = $this->walletService->getWalletCoins($wallet_id);

        $this->assertInstanceOf(Coin::class, $isCoin);
    }

    /** @test  */
    public function noneCoinsCaugthInAWallet(){
        $wallet_id = '1';
        $user_id = '1';
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => $wallet_id, 'user_id' => $user_id, 'transaction_balance' => 15]);

        $this->coinDataSource->getCoinsByWalletId($wallet_id)->shouldBeCalledOnce()->willReturn('Coins not found');
        $isCoin = $this->walletService->getWalletCoins($wallet_id);

        $this->assertEquals('Coins not found', $isCoin);
    }

    /** @test */
    public function noneWalletFoundById(){
        $wallet_id = '';

        $this->walletDataSource->getWalletById($wallet_id)->shouldBeCalledOnce()->willReturn(new Wallet());
        $isWallet = $this->walletService->find($wallet_id);

        $this->assertEquals(new Wallet(), $isWallet);
    }

    /** @test */
    public function noWalletOpenWithUserId(){
        $wallet_id = '1';
        $user_id = '2';
        $wallet = new Wallet();

        $this->walletDataSource->getWalletById($wallet_id)->shouldBeCalledOnce()->willReturn($wallet);
        $this->walletDataSource->createNewWalletWithUserId($user_id)->shouldBeCalledOnce()->willReturn($wallet_id);
        $isWallet = $this->walletService->open($user_id);

        $this->assertEquals($wallet, $isWallet);
    }
}
