<?php

namespace Tests\Routes;

use App\Models\Coin;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRoutesTest extends TestCase{

    use RefreshDatabase;

    protected function setUp():void{
        parent::setUp();
        Wallet::factory()->create(['wallet_id' => '1', 'user_id' => '25', 'transaction_balance' => 25.99]);
        Wallet::factory()->create(['wallet_id' => '2', 'user_id' => '1', 'transaction_balance' => 13.85]);
        Wallet::factory()->create(['wallet_id' => '3', 'user_id' => '5', 'transaction_balance' => 25.99]);
        Coin::factory(Coin::class)->create();
    }

    /* ---------------- FUNCIONAN -------------------------- */

    /** @test */
    public function getApiStatusTest(){
        $response = $this->get('/api/status');
        $response->assertStatus(200);
    }

    /** @test */
    public function buyCoinWithUSDWithSuccessResponse(){
        $response = $this->postJson('/api/coin/buy', ['coin_id'=>'1', 'wallet_id' => '1', 'amount_usd'=>10]);
        $response->assertStatus(200);
    }

    /** @test */
    public function buyCoinWithUSDWithBadRequestResponse(){
        $response1 = $this->postJson('/api/coin/buy');
        $response2 = $this->postJson('/api/coin/buy', []);
        $response3 = $this->postJson('/api/coin/buy', ['coin_id'=>'', 'wallet_id' => '1', 'amount_usd'=>0]);
        $response4 = $this->postJson('/api/coin/buy', ['coin_id'=>'1', 'wallet_id' => '', 'amount_usd'=>0]);
        $response5 = $this->postJson('/api/coin/buy', ['coin_id'=>'1', 'wallet_id' => '1', 'amount_usd'=>'']);

        $response1->assertStatus(400);
        $response2->assertStatus(400);
        $response3->assertStatus(400);
        $response4->assertStatus(400);
        $response5->assertStatus(400);
    }

    /** @test */
    public function buyCoinWithUSDWithNotFoundResponse(){
        $response = $this->postJson('/api/coin/buy', ['coin_id'=>'5', 'wallet_id' => '4', 'amount_usd'=>0]);
        $response->assertStatus(404);
    }

    /** @test */
    public function sellCoinWithBadRequestResponse(){
        $response = $this->postJson('/api/coin/sell');
        $response->assertStatus(400);
    }

    /** @test */
    public function walletOpenWithSuccessResponse(){
        $response = $this->postJson('/api/wallet/open', ['user_id' => '1']);
        $response->assertStatus(200);
    }

    /** @test */
    public function walletOpenWithBadRequestResponse(){
        $response = $this->postJson('/api/wallet/open');
        $response->assertStatus(400);
    }

    /** @test */
    public function getWalletCryptocurrenciesWithSuccessResponse(){
        $response = $this->get('/api/wallet/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function getWalletCryptocurrenciesWithBadRequestResponse(){
        $response = $this->get('/api/wallet/ ');
        $response->assertStatus(400);
    }

    /** @test */
    public function getWalletCryptocurrenciesWithNotFoundResponse(){
        $response = $this->get('/api/wallet/9');
        $response->assertStatus(404);
    }

    /** @test */
    public function getTotalBalanceOfAllMyCryptocurrenciesWithSuccessResponse(){
        $response = $this->get('/api/wallet/1/balance');
        $response->assertStatus(200);
    }

    /** @test */
    public function getTotalBalanceOfAllMyCryptocurrenciesWithBadRequestResponse(){
        $response = $this->get('/api/wallet/ /balance');
        $response->assertStatus(400);
    }

    /** @test */
    public function sellCoinWithSuccessResponse(){
        $response = $this->postJson('/api/coin/sell', ['coin_id' => '1', 'wallet_id' => '1', 'amount_usd' => 5]);
        $response->assertStatus(200);
    }

    /** @test */
    public function sellCoinWithNotFoundResponse(){
        $response = $this->postJson('/api/coin/sell', ['coin_id' => '1', 'wallet_id' => '1', 'amount_usd' => 0]);
        $response->assertStatus(404);
    }
    /* ----------- NO FUNCIONAN ------------------ */

    /** @test */
    public function getTotalBalanceOfAllMyCryptocurrenciesWithNotFoundResponse(){
        $response = $this->get('/api/wallet/9/balance');
        $response->assertStatus(404);
    }

}
