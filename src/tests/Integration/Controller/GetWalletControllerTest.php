<?php

namespace Tests\Integration\Controller;

use App\Models\Coin;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetWalletControllerTest extends TestCase{

    use RefreshDatabase;

    protected function setUp():void{
        parent::setUp();
        Wallet::factory()->create(['wallet_id' => '1', 'user_id' => '25', 'transaction_balance' => 25.99]);
        Wallet::factory()->create(['wallet_id' => '2', 'user_id' => '1', 'transaction_balance' => 13.85]);
        Wallet::factory()->create(['wallet_id' => '3', 'user_id' => '5', 'transaction_balance' => 25.99]);
        Coin::factory(Coin::class)->create();
    }

    /** @test */
    public function noWalletFoundForGivenId(){
        $response = $this->get('/api/wallet/5');

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'Wallet not found']);
    }

    /** @test */
    public function walletFoundWithOutCoinsForGivenId(){
        $response = $this->get('/api/wallet/2');

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'Coin not found']);
    }

    /** @test */
    public function noWalletFoundBadRequestResponse(){
        $response = $this->get('/api/wallet/ ');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Wallet not found']);
    }

    /** @test */
    public function getWalletWithCoins(){
        $response = $this->get('/api/wallet/1');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['wallet-data' => [["amount"=>"25.4","coin_id"=>"1","name"=>"Bitcoin","symbol"=>"BIT", "value_usd" => "63.88"]]]);
    }
}
