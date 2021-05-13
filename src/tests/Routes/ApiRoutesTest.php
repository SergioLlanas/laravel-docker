<?php

namespace Tests\Routes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function getApiStatusTest(){
        $response = $this->get('/api/status');
        $response->assertStatus(200);
    }

    /** @test */
    public function walletOpenTest(){
        $response = $this->postJson('/api/wallet/open', ['user_id' => '1']);
        $response->assertStatus(200);
    }

    /** @test */
    public function getWalletCryptocurrencies(){
        $response = $this->get('/api/wallet/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function getTotalBalanceOfAllMyCryptocurrencies(){
        $response = $this->get('/api/wallet/1/balance');
        $response->assertStatus(200);
    }

    /** @test */
    public function buyCoinWithUSD(){
        $response = $this->postJson('/api/coin/buy');
        $response->assertStatus(200);
    }

    /** @test */
    public function sellCoin(){
        $response = $this->postJson('/api/coin/sell');
        $response->assertStatus(200);
    }

}
