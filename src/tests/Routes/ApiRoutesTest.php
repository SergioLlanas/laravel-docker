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
        $response6 = $this->postJson('/api/coin/buy', ['coin_id'=>'1']);
        $response7 = $this->postJson('/api/coin/buy', ['coin_id'=>'']);
        $response8 = $this->postJson('/api/coin/buy', ['wallet_id'=>'1']);
        $response9 = $this->postJson('/api/coin/buy', ['wallet_id'=>'']);
        $response10 = $this->postJson('/api/coin/buy', ['amount_usd'=>'']);
        $response11 = $this->postJson('/api/coin/buy', ['amount_usd'=>'12']);
        $response12 = $this->postJson('/api/coin/buy', ['amount_usd'=>12]);
        $response13 = $this->postJson('/api/coin/buy', ['coin_id'=>'1', 'wallet_id' => '1']);
        $response14 = $this->postJson('/api/coin/buy', ['coin_id'=>'', 'wallet_id' => '1']);
        $response15 = $this->postJson('/api/coin/buy', ['coin_id'=>'1', 'wallet_id' => '']);
        $response16 = $this->postJson('/api/coin/buy', ['coin_id'=>'1', 'amount_usd'=>'']);
        $response17 = $this->postJson('/api/coin/buy', ['coin_id'=>'1', 'amount_usd'=>'1']);
        $response18 = $this->postJson('/api/coin/buy', ['coin_id'=>'1', 'amount_usd'=>0]);
        $response19 = $this->postJson('/api/coin/buy', ['wallet_id'=>'1', 'amount_usd'=>'']);
        $response20 = $this->postJson('/api/coin/buy', ['wallet_id'=>'1', 'amount_usd'=>'1']);
        $response21 = $this->postJson('/api/coin/buy', ['wallet_id'=>'1', 'amount_usd'=>0]);

        $response1->assertStatus(400);
        $response2->assertStatus(400);
        $response3->assertStatus(400);
        $response4->assertStatus(400);
        $response5->assertStatus(400);
        $response6->assertStatus(400);
        $response7->assertStatus(400);
        $response8->assertStatus(400);
        $response9->assertStatus(400);
        $response10->assertStatus(400);
        $response11->assertStatus(400);
        $response12->assertStatus(400);
        $response13->assertStatus(400);
        $response14->assertStatus(400);
        $response15->assertStatus(400);
        $response16->assertStatus(400);
        $response17->assertStatus(400);
        $response18->assertStatus(400);
        $response19->assertStatus(400);
        $response20->assertStatus(400);
        $response21->assertStatus(400);
    }

    /** @test */
    public function buyCoinWithUSDWithNotFoundResponse(){
        $response1 = $this->postJson('/api/coin/buy', ['coin_id'=>'5', 'wallet_id' => '4', 'amount_usd'=>0]);
        $response2 = $this->postJson('/api/coin/buy', ['coin_id'=>'asd', 'wallet_id' => '1', 'amount_usd'=>0]);

        $response1->assertStatus(404);
        $response2->assertStatus(404);
    }

    /** @test */
    public function sellCoinWithSuccessResponse(){
        $response = $this->postJson('/api/coin/sell', ['coin_id' => '1', 'wallet_id' => '1', 'amount_usd' => 5]);

        $response->assertStatus(200);
    }

    /** @test */
    public function sellCoinWithBadRequestResponse(){
        $response1 = $this->postJson('/api/coin/sell');
        $response2 = $this->postJson('/api/coin/sell', []);
        $response3 = $this->postJson('/api/coin/sell', ['coin_id'=>'', 'wallet_id' => '1', 'amount_usd'=>0]);
        $response4 = $this->postJson('/api/coin/sell', ['coin_id'=>'1', 'wallet_id' => '', 'amount_usd'=>0]);
        $response5 = $this->postJson('/api/coin/sell', ['coin_id'=>'1', 'wallet_id' => '1', 'amount_usd'=>'']);
        $response6 = $this->postJson('/api/coin/sell', ['coin_id'=>'1']);
        $response7 = $this->postJson('/api/coin/sell', ['coin_id'=>'']);
        $response8 = $this->postJson('/api/coin/sell', ['wallet_id'=>'1']);
        $response9 = $this->postJson('/api/coin/sell', ['wallet_id'=>'']);
        $response10 = $this->postJson('/api/coin/sell', ['amount_usd'=>'']);
        $response11 = $this->postJson('/api/coin/sell', ['amount_usd'=>'12']);
        $response12 = $this->postJson('/api/coin/sell', ['amount_usd'=>12]);
        $response13 = $this->postJson('/api/coin/sell', ['coin_id'=>'1', 'wallet_id' => '1']);
        $response14 = $this->postJson('/api/coin/sell', ['coin_id'=>'', 'wallet_id' => '1']);
        $response15 = $this->postJson('/api/coin/sell', ['coin_id'=>'1', 'wallet_id' => '']);
        $response16 = $this->postJson('/api/coin/sell', ['coin_id'=>'1', 'amount_usd'=>'']);
        $response17 = $this->postJson('/api/coin/sell', ['coin_id'=>'1', 'amount_usd'=>'1']);
        $response18 = $this->postJson('/api/coin/sell', ['coin_id'=>'1', 'amount_usd'=>0]);
        $response19 = $this->postJson('/api/coin/sell', ['wallet_id'=>'1', 'amount_usd'=>'']);
        $response20 = $this->postJson('/api/coin/sell', ['wallet_id'=>'1', 'amount_usd'=>'1']);
        $response21 = $this->postJson('/api/coin/sell', ['wallet_id'=>'1', 'amount_usd'=>0]);

        $response1->assertStatus(400);
        $response2->assertStatus(400);
        $response3->assertStatus(400);
        $response4->assertStatus(400);
        $response5->assertStatus(400);
        $response6->assertStatus(400);
        $response7->assertStatus(400);
        $response8->assertStatus(400);
        $response9->assertStatus(400);
        $response10->assertStatus(400);
        $response11->assertStatus(400);
        $response12->assertStatus(400);
        $response13->assertStatus(400);
        $response14->assertStatus(400);
        $response15->assertStatus(400);
        $response16->assertStatus(400);
        $response17->assertStatus(400);
        $response18->assertStatus(400);
        $response19->assertStatus(400);
        $response20->assertStatus(400);
        $response21->assertStatus(400);
    }

    /** @test */
    public function sellCoinWithNotFoundResponse(){
        $response1 = $this->postJson('/api/coin/sell', ['coin_id' => '1', 'wallet_id' => '1', 'amount_usd' => 0]);
        $response2 = $this->postJson('/api/coin/sell', ['coin_id'=>'asd', 'wallet_id' => '1', 'amount_usd'=>0]);

        $response1->assertStatus(404);
        $response2->assertStatus(404);
    }

    /** @test */
    public function walletOpenWithSuccessResponse(){
        $response = $this->postJson('/api/wallet/open', ['user_id' => '1']);

        $response->assertStatus(200);
    }

    /** @test */
    public function walletOpenWithBadRequestResponse(){
        $response1 = $this->postJson('/api/wallet/open');
        $response2 = $this->postJson('/api/wallet/open', []);
        $response3 = $this->postJson('/api/wallet/open', ['user_id'=>'']);

        $response1->assertStatus(400);
        $response2->assertStatus(400);
        $response3->assertStatus(400);
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
        $response1 = $this->get('/api/wallet/9');
        $response2 = $this->get('/api/wallet/');

        $response1->assertStatus(404);
        $response2->assertStatus(404);
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
    public function getTotalBalanceOfAllMyCryptocurrenciesWithNotFoundResponse(){
        $response = $this->get('/api/wallet/9/balance');
        $response2 = $this->get('/api/wallet//balance');
        $response3 = $this->get('/api/wallet/balance');

        $response->assertStatus(404);
        $response2->assertStatus(404);
        $response3->assertStatus(404);
    }
}
