<?php

namespace Tests\Integration\DataSources;

use App\DataSource\Database\CoinDataSource;
use App\Models\Coin;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinDataSourceTest extends TestCase{

    use RefreshDatabase;

    /** @test */
    public function getCoinById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getCoinById('1');

        $this->assertInstanceOf(Coin::class, $coin);
    }

    /** @test */
    public function noCoinCaughtById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        try{
            $coinDataSource->getCoinById('2');
        }catch (Exception $exception){
            $this->assertEquals('Coin not found', $exception->getMessage());
        }
    }

    /** @test */
    public function getCoinNameById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getCoinNameById('1');

        $this->assertEquals('Bitcoin', $coin);
    }

    /** @test */
    public function noCoinNameCaughtById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        try{
            $coinDataSource->getCoinById('2');
        }catch (Exception $exception){
            $this->assertEquals('Coin not found', $exception->getMessage());
        }
    }

    /** @test */
    public function getCoinSymbolById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getCoinSymbolById('1');

        $this->assertEquals('BIT', $coin);
    }

    /** @test */
    public function noCoinSymbolCaughtById(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        try{
            $coinDataSource->getCoinById('2');
        }catch (Exception $exception){
            $this->assertEquals('Coin not found', $exception->getMessage());
        }
    }

    /** @test */
    public function getAmountCoinByIdAndWallet(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getAmountCoinByIdAndWallet('1', '1');
        $this->assertEquals(25.4, $coin);
    }

    /** @test */
    public function noAmountCoinByIdAndWallet(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        try{
            $coinDataSource->getAmountCoinByIdAndWallet('2', '1');
        }catch (Exception $exception){
            $this->assertEquals('Coin not found', $exception->getMessage());
        }
    }

    /** @test */
    public function doNewTransaction(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->doNewTransaction('1', '2', 25, 'bitcoin', 'BIT', 25);

        $this->assertEquals('2', $coin);
    }

}
