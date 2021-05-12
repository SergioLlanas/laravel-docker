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
    public function getAllCoinsForGivenWalletId(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getCoinsByWalletId('1');

        $this->assertEquals(1, $coin->count());
    }

    /** @test */
    public function noCoinsForGivenWalletId(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->getCoinsByWalletId('2');
        $coin2 = $coinDataSource->getCoinsByWalletId(' ');

        $this->assertEquals(0, $coin->count());
        $this->assertEquals(0, $coin2->count());
    }

    /** @test */
    public function doNewTransaction(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->doNewTransaction('1', '2', 25, 'bitcoin', 'BIT', 25);

        $this->assertEquals('2', $coin);
    }

    /** @test */
    public function newTransactionNotDone(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        try{
            $coinDataSource->doNewTransaction(' ', '2', 25, 'bitcoin', 'BIT', 25);
        }catch (Exception $exception){
            $this->assertEquals('Transaction not done', $exception->getMessage());
        }
        try{
            $coinDataSource->doNewTransaction('1', '', 25, 'bitcoin', 'BIT', 25);
        }catch (Exception $exception){
            $this->assertEquals('Transaction not done', $exception->getMessage());
        }
        try{
            $coinDataSource->doNewTransaction('1', '2', -5, 'bitcoin', 'BIT', 25);
        }catch (Exception $exception){
            $this->assertEquals('Transaction not done', $exception->getMessage());
        }
        try{
            $coinDataSource->doNewTransaction('1', '2', 5, '', 'BIT', 25);
        }catch (Exception $exception){
            $this->assertEquals('Transaction not done', $exception->getMessage());
        }

    }

    /** @test */
    public function incrementAmountCoinForGivenIds(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->incrementAmountCoinByIdAndWallet('1', 15, '1');

        $this->assertTrue($coin);
    }

    /** @test */
    public function incrementAmountCoinForGivenIdsNotDone(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        try{
            $coinDataSource->incrementAmountCoinByIdAndWallet('15', -5, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }

        try{
            $coinDataSource->incrementAmountCoinByIdAndWallet('  ', -5, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }

        try{
            $coinDataSource->incrementAmountCoinByIdAndWallet('  ', 25, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }

        try{
            $coinDataSource->incrementAmountCoinByIdAndWallet('1', 25, '5');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }

        try{
            $coinDataSource->incrementAmountCoinByIdAndWallet('1', -25, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }
    }

    /** @test */
    public function decrementAmountCoinForGivenIds(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        $coin = $coinDataSource->decrementAmountCoinByIdAndWallet('1', 15, '1');

        $this->assertTrue($coin);
    }

    /** @test */
    public function decrementAmountCoinForGivenIdsNotDone(){
        Coin::factory(Coin::class)->create();
        $coinDataSource = new CoinDataSource();

        try{
            $coinDataSource->decrementAmountCoinByIdAndWallet('15', -5, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }

        try{
            $coinDataSource->decrementAmountCoinByIdAndWallet('  ', -5, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }

        try{
            $coinDataSource->decrementAmountCoinByIdAndWallet('  ', 25, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }

        try{
            $coinDataSource->decrementAmountCoinByIdAndWallet('1', 25, '5');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }

        try{
            $coinDataSource->decrementAmountCoinByIdAndWallet('1', -25, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount coin not updated', $exception->getMessage());
        }
    }

}
