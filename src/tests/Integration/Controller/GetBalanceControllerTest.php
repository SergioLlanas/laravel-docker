<?php

namespace Tests\Integration\Controller;

use App\Models\Coin;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetBalanceControllerTest extends TestCase{

    use RefreshDatabase;

    /** @test */
    public function balanceNotFoundForGivenId(){
        Wallet::factory(Wallet::class)->create();

        $response = $this->get('api/wallet/2/balance');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Wallet not found']);
    }

    /** @test */
    public function balanceFoundForGivenId(){
        Wallet::factory(Wallet::class)->create();
        Coin::factory(Coin::class)->create();

        $response = $this->get('api/wallet/1/balance');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['balance_usd' => 8824.042]);
    }

}
