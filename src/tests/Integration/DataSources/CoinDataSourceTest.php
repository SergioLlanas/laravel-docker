<?php

namespace Tests\Integration\DataSources;

use App\DataSource\Database\CoinDataSource;
use App\Models\Coin;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinDataSourceTest extends TestCase{

    use RefreshDatabase;
    private $coinDataSource;

    protected function setUp():void{
        parent::setUp();
        Coin::factory(Coin::class)->create();
        $this->coinDataSource = new CoinDataSource();
    }

    /** @test */
    public function getCoinById(){
        $coin = $this->coinDataSource->getCoinById('1');

        $this->assertInstanceOf(Coin::class, $coin);
    }

    /** @test */
    public function noCoinCaughtById(){
        try{
            $this->coinDataSource->getCoinById('2');
        }catch (Exception $exception){
            $this->assertEquals('Coin not found', $exception->getMessage());
        }
    }

    /** @test */
    public function getCoinNameById(){
        $coin = $this->coinDataSource->getCoinNameById('1');

        $this->assertEquals('Bitcoin', $coin);
    }

    /** @test */
    public function noCoinNameCaughtById(){
        try{
            $this->coinDataSource->getCoinById('2');
        }catch (Exception $exception){
            $this->assertEquals('Coin not found', $exception->getMessage());
        }
    }

    /** @test */
    public function getCoinSymbolById(){
        $coin = $this->coinDataSource->getCoinSymbolById('1');

        $this->assertEquals('BIT', $coin);
    }

    /** @test */
    public function noCoinSymbolCaughtById(){
        try{
            $this->coinDataSource->getCoinById('2');
        }catch (Exception $exception){
            $this->assertEquals('Coin not found', $exception->getMessage());
        }
    }

    /** @test */
    public function getAmountCoinByIdAndWallet(){
        $coin = $this->coinDataSource->getAmountCoinByIdAndWallet('1', '1');
        $this->assertEquals(25.4, $coin);
    }

    /** @test */
    public function noAmountCoinByIdAndWallet(){
        try{
            $this->coinDataSource->getAmountCoinByIdAndWallet('2', '1');
        }catch (Exception $exception){
            $this->assertEquals('Coin not found', $exception->getMessage());
        }
    }

    /** @test */
    public function getAllCoinsForGivenWalletId(){
        $coin = $this->coinDataSource->getCoinsByWalletId('1');

        $this->assertEquals(1, $coin->count());
    }

    /** @test */
    public function noCoinsForGivenWalletId(){
        $coin = $this->coinDataSource->getCoinsByWalletId('2');
        $coin2 = $this->coinDataSource->getCoinsByWalletId(' ');

        $this->assertEquals(0, $coin->count());
        $this->assertEquals(0, $coin2->count());
    }

    /** @test */
    public function doNewTransaction(){
        $coin = $this->coinDataSource->doNewTransaction('1', '2', 25, 'bitcoin', 'BIT', 25);

        $this->assertEquals('2', $coin);
    }

    /** @test */
    public function newTransactionNotDone(){
        try{
            $this->coinDataSource->doNewTransaction(' ', '2', 25, 'bitcoin', 'BIT', 25);
        }catch (Exception $exception){
            $this->assertEquals('Transaction not done', $exception->getMessage());
        }

        try{
            $this->coinDataSource->doNewTransaction('1', '', 25, 'bitcoin', 'BIT', 25);
        }catch (Exception $exception){
            $this->assertEquals('Transaction not done', $exception->getMessage());
        }

        try{
            $this->coinDataSource->doNewTransaction('1', '2', -5, 'bitcoin', 'BIT', 25);
        }catch (Exception $exception){
            $this->assertEquals('Transaction not done', $exception->getMessage());
        }

        try{
            $this->coinDataSource->doNewTransaction('1', '2', 5, '', 'BIT', 25);
        }catch (Exception $exception){
            $this->assertEquals('Transaction not done', $exception->getMessage());
        }
    }

    /** @test */
    public function incrementAmountCoinForGivenIds(){
        $coin = $this->coinDataSource->incrementAmountCoinByIdAndWallet('1', 15, '1');

        $this->assertTrue($coin);
    }

    /** @test */
    public function incrementAmountCoinForGivenIdsNotDone(){
        try{
            $this->coinDataSource->incrementAmountCoinByIdAndWallet('15', -5, '1');
        }catch(Exception $exception){
            $this->assertEquals('Can´t buy negative number', $exception->getMessage());
        }

        try{
            $this->coinDataSource->incrementAmountCoinByIdAndWallet('  ', -5, '1');
        }catch(Exception $exception){
            $this->assertEquals('Can´t buy negative number', $exception->getMessage());
        }

        try{
            $this->coinDataSource->incrementAmountCoinByIdAndWallet('  ', 25, '1');
        }catch(Exception $exception){
            $this->assertEquals('Coin with specified Id was not found', $exception->getMessage());
        }

        try{
            $this->coinDataSource->incrementAmountCoinByIdAndWallet('1', 25, '5');
        }catch(Exception $exception){
            $this->assertEquals('Coin with specified Id was not found', $exception->getMessage());
        }

        try{
            $this->coinDataSource->incrementAmountCoinByIdAndWallet('1', -25, '1');
        }catch(Exception $exception){
            $this->assertEquals('Can´t buy negative number', $exception->getMessage());
        }
    }

    /** @test */
    public function decrementAmountCoinForGivenIds(){
        $coin = $this->coinDataSource->decrementAmountCoinByIdAndWallet('1', 15, '1');

        $this->assertTrue($coin);
    }

    /** @test */
    public function decrementAmountCoinForGivenIdsNotDone(){
        try{
            $this->coinDataSource->decrementAmountCoinByIdAndWallet('15', -5, '1');
        }catch(Exception $exception){
            $this->assertEquals('Can´t buy negative number', $exception->getMessage());
        }

        try{
            $this->coinDataSource->decrementAmountCoinByIdAndWallet('  ', -5, '1');
        }catch(Exception $exception){
            $this->assertEquals('Can´t buy negative number', $exception->getMessage());
        }

        try{
            $this->coinDataSource->decrementAmountCoinByIdAndWallet('  ', 25, '1');
        }catch(Exception $exception){
            $this->assertEquals('Coin with specified Id was not found', $exception->getMessage());
        }

        try{
            $this->coinDataSource->decrementAmountCoinByIdAndWallet('1', 25, '5');
        }catch(Exception $exception){
            $this->assertEquals('Coin with specified Id was not found', $exception->getMessage());
        }

        try{
            $this->coinDataSource->decrementAmountCoinByIdAndWallet('1', -25, '1');
        }catch(Exception $exception){
            $this->assertEquals('Can´t buy negative number', $exception->getMessage());
        }
    }
}
