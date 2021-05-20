<?php

namespace Tests\Integration\DataSources;

use App\DataSource\Database\WalletDataSource;
use App\Models\Wallet;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletDataSourceTest extends TestCase{

    use RefreshDatabase;
    private $walletDataSource;

    protected function setUp():void{
        parent::setUp();
        Wallet::factory(Wallet::class)->create();
        $this->walletDataSource = new WalletDataSource();
    }

    /** @test */
    public function getWalletById(){
        $wallet = $this->walletDataSource->getWalletById('1');

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    /** @test */
    public function noWalletFoundForTheGivenId(){
        try{
            $this->walletDataSource->getWalletById('9');
        }catch (Exception $exception) {
            $this->assertEquals('Wallet not found', $exception->getMessage());
        }
    }

    /** @test */
    public function createNewWalletWithUserId(){
        $wallet = $this->walletDataSource->createNewWalletWithUserId('25');

        $this->assertEquals('2', $wallet);
    }

    /** @test */
    public function walletNotCreatedForNullUser(){
        try{
            $this->walletDataSource->createNewWalletWithUserId('');
        }catch (Exception $exception) {
            $this->assertEquals('User was not found', $exception->getMessage());
        }
    }

    /** @test */
    public function updateTransactionBalanceForGivenWalletIdWhenWeBuy(){
        $wallet = $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(15, '1');

        $this->assertTrue($wallet);
    }

    /** @test */
    public function updateNotDoneForTransactionBalanceForGivenWalletIdWhenWeBuy(){
        try{
            $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(0, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount_usd have to be positive', $exception->getMessage());
        }

        try{
            $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(-1, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount_usd have to be positive', $exception->getMessage());
        }

        try{
            $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(25, '');
        }catch(Exception $exception){
            $this->assertEquals('Empty Wallet field', $exception->getMessage());
        }

        try{
            $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(25, '  ');
        }catch(Exception $exception){
            $this->assertEquals('Empty Wallet field', $exception->getMessage());
        }
    }

    /** @test */
    public function updateTransactionBalanceForGivenWalletIdWhenWeSell(){
        $wallet = $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(15, '1');

        $this->assertTrue($wallet);
    }

    /** @test */
    public function updateNotDoneForTransactionBalanceForGivenWalletIdWhenWeSell(){
        try{
            $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(0, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount_usd have to be positive', $exception->getMessage());
        }

        try{
            $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(-1, '1');
        }catch(Exception $exception){
            $this->assertEquals('Amount_usd have to be positive', $exception->getMessage());
        }

        try{
            $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(25, '');
        }catch(Exception $exception){
            $this->assertEquals('Empty Wallet field', $exception->getMessage());
        }

        try{
            $this->walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(25, '  ');
        }catch(Exception $exception){
            $this->assertEquals('Empty Wallet field', $exception->getMessage());
        }
    }
}
