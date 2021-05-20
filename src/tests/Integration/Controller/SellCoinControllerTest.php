<?php

namespace Tests\Integration\Controller;

use App\Models\Coin;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SellCoinControllerTest extends TestCase{

    use RefreshDatabase;

    protected function setUp():void{
        parent::setUp();
        Coin::factory(Coin::class)->create();
        Wallet::factory(Wallet::class)->create();
    }

    /** @test */
    public function sellCoinWithSuccessResponse(){
        $response = $this->postJson('/api/coin/sell',['coin_id' => '1', 'wallet_id' => '1', 'amount_usd'=>10]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function tryToSellCoinsWithOutCoinId(){
        $response1 = $this->postJson('/api/coin/sell',['coin_id' => '', 'wallet_id' => '1', 'amount_usd'=>10]);
        $response2 = $this->postJson('/api/coin/sell',['coin_id' => '  ', 'wallet_id' => '1', 'amount_usd'=>10]);

        $response1->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Sell not done']);
        $response2->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Sell not done']);
    }

    /** @test */
    public function tryToSellCoinsWithOutWalletId(){
        $response1 = $this->postJson('/api/coin/sell',['coin_id' => '1', 'wallet_id' => '', 'amount_usd'=>10]);
        $response2 = $this->postJson('/api/coin/sell',['coin_id' => '1', 'wallet_id' => '  ', 'amount_usd'=>10]);

        $response1->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Sell not done']);
        $response2->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Sell not done']);
    }

    /** @test */
    public function tryToSellCoinsWithOutAmount(){
        $response = $this->postJson('/api/coin/sell',['coin_id' => '1', 'wallet_id' => '1', 'amount_usd'=>'']);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Sell not done']);
    }

    /** @test */
    public function tryToSellCoinsForBadWalletId(){
        $response = $this->postJson('/api/coin/sell',['coin_id' => '1', 'wallet_id' => '2', 'amount_usd'=>10]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'Coin not found']);
    }

    /** @test */
    public function tryToSellCoinsForBadCoinId(){
        $response = $this->postJson('/api/coin/sell',['coin_id' => 'a', 'wallet_id' => '2', 'amount_usd'=>10]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'Coin not found']);
    }
}
