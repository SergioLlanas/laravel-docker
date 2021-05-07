<?php

namespace Tests\Integration\DataSources;

use App\DataSource\Database\WalletDataSource;
use App\Models\Wallet;
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
    public function getWalletWithMaxId(){
        Wallet::factory(Wallet::class)->create();
        $walletDataSource = new WalletDataSource();

        $wallet = $walletDataSource->getWalletWithMaxId();

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

}
