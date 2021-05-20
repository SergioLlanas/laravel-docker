<?php

namespace Tests\Integration\Controller;

use App\Models\Coin;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class BuyCoinControllerTest extends TestCase{

    use RefreshDatabase;

    protected function setUp():void{
        parent::setUp();
        Coin::factory(Coin::class)->create();
        Wallet::factory(Wallet::class)->create();
    }

    /** @test */
    public function buyCoinWithSuccessResponse(){
        $response = $this->postJson('/api/coin/buy',['coin_id' => '1', 'wallet_id' => '1', 'amount_usd'=>10]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function tryToBuyCoinsWithOutCoinId(){
        $response1 = $this->postJson('/api/coin/buy',['coin_id' => '', 'wallet_id' => '1', 'amount_usd'=>10]);
        $response2 = $this->postJson('/api/coin/buy',['coin_id' => '  ', 'wallet_id' => '1', 'amount_usd'=>10]);

        $response1->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Coin and wallet not found']);
        $response2->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Coin and wallet not found']);
    }

    /** @test */
    public function tryToBuyCoinsWithOutWalletId(){
        $response1 = $this->postJson('/api/coin/buy',['coin_id' => '1', 'wallet_id' => '', 'amount_usd'=>10]);
        $response2 = $this->postJson('/api/coin/buy',['coin_id' => '1', 'wallet_id' => '  ', 'amount_usd'=>10]);

        $response1->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Coin and wallet not found']);
        $response2->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Coin and wallet not found']);
    }

    /** @test */
    public function tryToBuyCoinsWithOutAmount(){
        $response = $this->postJson('/api/coin/buy',['coin_id' => '1', 'wallet_id' => '1', 'amount_usd'=>'']);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Coin and wallet not found']);
    }

    /** @test */
    public function tryToBuyCoinsForBadWalletId(){
        $response = $this->postJson('/api/coin/buy',['coin_id' => '1', 'wallet_id' => '2', 'amount_usd'=>10]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'Wallet not found']);
    }

    /** @test */
    public function tryToBuyCoinsForBadCoinId(){
        $response = $this->postJson('/api/coin/buy',['coin_id' => 'a', 'wallet_id' => '2', 'amount_usd'=>10]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'Coin with specific Id not found']);
    }

}
