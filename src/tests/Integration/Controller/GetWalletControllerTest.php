<?php

namespace Tests\Integration\Controller;

use App\Models\Coin;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetWalletControllerTest extends TestCase{

    use RefreshDatabase;

    /** @test */
    public function noWalletFoundForGivenId(){
        Wallet::factory(Wallet::class)->create();

        $response = $this->get('/api/wallet/5');

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'Wallet not found']);
    }

    /** @test */
    public function getWalletWithOutCoins(){
        Wallet::factory(Wallet::class)->create();
        Coin::factory(Coin::class)->create();

        $response = $this->get('/api/wallet/1');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Coins not found']);
    }

    /** @test */
    public function getWalletWithCoins(){
        Wallet::factory(Wallet::class)->create();
        Coin::factory(Coin::class)->create();

        $response = $this->get('/api/wallet/1');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['wallet-data' => [["amount"=>"25.4","coin_id"=>"1","name"=>"Bitcoin","symbol"=>"BIT", "value_usd" => "63.88"]]]);
    }

}
