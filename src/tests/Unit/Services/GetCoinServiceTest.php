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
    }

    /** @test  */
    public function getCoinNameForGivenId(){
        $coin_id = '1';
        $coin_name = 'Bitcoin';
        $coin = new Coin();
        $coin->fill(['id_transaction' => 1, 'coin_id' => $coin_id, 'nameCoin' => $coin_name,
            'symbol' => 'BTC', 'wallet_id' => '1', 'amount_coins' => 10]);

        $this->coinDataSource->getCoinNameById($coin_id)->shouldBeCalledOnce()->willReturn($coin_name);

        $isCoinName = $this->coinService->getCoinName($coin_id);

        $this->assertEquals($coin_name,$isCoinName );
    }

    /** @test  */
    public function noneCoinNameFoundForGivenId(){
        $coin_id = '1';
        $coin_name = 'Bitcoin';
        $coin = new Coin();
        $coin->fill(['id_transaction' => 1, 'coin_id' => $coin_id, 'nameCoin' => $coin_name,
            'symbol' => 'BTC', 'wallet_id' => '1', 'amount_coins' => 10]);

        $this->coinDataSource->getCoinNameById('2')->shouldBeCalledOnce()->willReturn('Coin not found');

        $isCoinName = $this->coinService->getCoinName('2');

        $this->assertEquals('Coin not found',$isCoinName);
    }
}
