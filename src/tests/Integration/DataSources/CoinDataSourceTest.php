<?php

namespace Tests\Integration\DataSources;

use App\DataSource\Database\CoinDataSource;
use App\Models\Coin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinDataSourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function getCoinById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getCoinById('1');

        $this->assertInstanceOf(Coin::class, $coin);
    }

    /** @test */
    /*public function getCoinNameById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getCoinById('1');

        $this->assertInstanceOf('Bitcoin', $coin);
    }*/

    /** @test */
   /* public function getCoinSymbolById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getCoinById('1');

        $this->assertInstanceOf('BTC', $coin);
    }*/

}
