<?php

namespace Tests\Integration\DataSources;

use App\DataSource\Database\WalletDataSource;
use App\Models\Wallet;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletDataSourceTest extends TestCase{

    use RefreshDatabase;

    /** @test */
    public function getWalletById(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        $wallet = $walletDataSource->getWalletById('1');

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    /** @test */
    public function noWalletFoundForTheGivenId(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        try{
            $walletDataSource->getWalletById('9');
        }catch (Exception $exception) {
            $this->assertEquals('Wallet not found', $exception->getMessage());
        }
    }

    /** @test */
    public function createNewWalletWithUserId(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        $wallet = $walletDataSource->createNewWalletWithUserId('25');

        $this->assertEquals('2', $wallet);
    }

    /** @test */
    public function walletNotCreatedForNullUser(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        try{
            $walletDataSource->createNewWalletWithUserId('');
        }catch (Exception $exception) {
            $this->assertEquals('Wallet not created', $exception->getMessage());
        }
    }

    /** @test */
    public function updateTransactionBalanceForGivenWalletIdWhenWeBuy(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        $wallet = $walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(15, '1');

        $this->assertTrue($wallet);
    }

    /** @test */
    public function updateNotDoneForTransactionBalanceForGivenWalletIdWhenWeBuy(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        try{
            $walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(0, '1');
        }catch(Exception $exception){
            $this->assertEquals('Wallet not updated', $exception->getMessage());
        }

        try{
            $walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(-1, '1');
        }catch(Exception $exception){
            $this->assertEquals('Wallet not updated', $exception->getMessage());
        }

        try{
            $walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(25, '');
        }catch(Exception $exception){
            $this->assertEquals('Wallet not updated', $exception->getMessage());
        }

        try{
            $walletDataSource->updateTransactionBalanceOfWalletIdWhenIBuy(25, '  ');
        }catch(Exception $exception){
            $this->assertEquals('Wallet not updated', $exception->getMessage());
        }
    }

    /** @test */
    public function updateTransactionBalanceForGivenWalletIdWhenWeSell(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        $wallet = $walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(15, '1');

        $this->assertTrue($wallet);
    }

    /** @test */
    public function updateNotDoneForTransactionBalanceForGivenWalletIdWhenWeSell(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        try{
            $walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(0, '1');
        }catch(Exception $exception){
            $this->assertEquals('Wallet not updated', $exception->getMessage());
        }

        try{
            $walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(-1, '1');
        }catch(Exception $exception){
            $this->assertEquals('Wallet not updated', $exception->getMessage());
        }

        try{
            $walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(25, '');
        }catch(Exception $exception){
            $this->assertEquals('Wallet not updated', $exception->getMessage());
        }

        try{
            $walletDataSource->updateTransactionBalanceOfWalletIdWhenISell(25, '  ');
        }catch(Exception $exception){
            $this->assertEquals('Wallet not updated', $exception->getMessage());
        }
    }

}
