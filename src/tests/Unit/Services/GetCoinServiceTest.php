<?php

namespace Tests\Unit\Services;

use App\DataSource\Database\CoinDataSource;
use App\Models\Coin;
use App\Services\GetCoinService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class GetCoinServiceTest extends TestCase{

    private $coinDataSource;
    private $coinService;

    protected function setUp(): void{
        parent::setUp();
        $prophet = new Prophet();
        $this->coinDataSource = $prophet->prophesize(CoinDataSource::class);
        $this->coinService = new GetCoinService($this->coinDataSource->reveal());

        $coin = new Coin();
        $coin->fill(['id_transaction' => 1, 'coin_id' => '1', 'nameCoin' => 'Bitcoin',
            'symbol' => 'BTC', 'wallet_id' => '1', 'amount_coins' => 10]);
    }

    /** @test  */
    public function getCoinNameForGivenId(){
        $this->coinDataSource->getCoinNameById('1')->shouldBeCalledOnce()->willReturn('Bitcoin');
        $isCoinName = $this->coinService->getCoinName('1');

        $this->assertEquals('Bitcoin',$isCoinName);
    }

    /** @test  */
    public function noneCoinNameFoundForGivenId(){
        $this->coinDataSource->getCoinNameById('2')->shouldBeCalledOnce()->willReturn('Coin not found');
        $isCoinName = $this->coinService->getCoinName('2');

        $this->assertEquals('Coin not found',$isCoinName);
    }
}
