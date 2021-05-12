<?php

namespace Tests\Integration\Controller;

use App\Models\Coin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class BuyCoinControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testExample(){
        Coin::factory(Coin::class)->create();

        $response = $this->postJson('/api/coin/buy',['coin_id' => '1', 'wallet_id' => '1', 'amount_usd'=>10]);

        //$response->assertStatus(Response::HTTP_OK);
        //$response = $this->get('/');

        //$response->assertStatus(200);
    }
}
