<?php

namespace Tests\Unit\Services;

use App\DataSource\Database\CoinDataSource;
use App\DataSource\Database\EloquentUserDataSource;
use App\DataSource\Database\WalletDataSource;
use App\Models\Wallet;
use App\Services\EarlyAdopter\IsEarlyAdopterService;
use App\Services\GetWalletService;
use Illuminate\Database\Eloquent\Model;
use Prophecy\Prophet;
use Tests\TestCase;

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
        $user_id = '25';
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => $wallet_id, 'user_id' => $user_id]);

        $this->walletDataSource->getWalletById($wallet_id)->shouldBeCalledOnce()->willReturn($wallet);

        $isWallet = $this->walletService->open($user_id);

        //$this->assertEquals('1', $isWallet->wallet_id);

        $this->assertInstanceOf(Wallet::class, $isWallet);
    }

    /** @test */
    /*public function getExistingWalletById(){
        $wallet_id = '1';
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => $wallet_id, 'user_id' => '25']);

        $this->walletDataSource->getWalletById($wallet_id)->shouldBeCalledOnce()->willReturn($wallet);

        $isWallet = $this->walletService->find($wallet_id);

        $this->assertInstanceOf(Wallet::class, $isWallet);
    }*/

    /** @test */
    /*public function getWalletWithOutUserId(){
        $wallet_id = '1';
        $wallet = new Wallet();
        $wallet->fill(['wallet_id' => '1', 'user_id' => '']);

        $this->walletDataSource->getWalletById($wallet_id)->shouldBeCalledOnce()->willReturn('Wallet not created');

        $isWallet = $this->walletService->find($wallet_id);

        $this->assertEquals('Wallet not created', $isWallet);

       // $this->assertInstanceOf(Wallet::class, $isWallet);
    }*/

}
