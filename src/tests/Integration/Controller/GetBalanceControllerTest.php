<?php

namespace Tests\Integration\Controller;

use App\Models\Coin;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetBalanceControllerTest extends TestCase{

    use RefreshDatabase;

    protected function setUp():void{
        parent::setUp();
        Wallet::factory(Wallet::class)->create();
        Coin::factory(Coin::class)->create();
    }

    /** @test */
    public function balanceNotFoundForGivenId(){
        $response = $this->get('api/wallet/2/balance');

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson(['error' => 'Wallet not found']);
    }

    /** @test */
    public function balanceFoundForGivenId(){
        $response = $this->get('api/wallet/1/balance');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['balance_usd' => 25.99]);
    }
}
