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
    public function getWalletCryptocurrencies(){
        $response = $this->get('/api/wallet/1');
        var_dump($response->getContent());
        $response->assertStatus(200);
    }

    /** @test */
    /*public function user(){
        $response = $this->get('/api/user/1');
        $response->assertStatus(200);
    }*/

    /** @test */
    /*public function walletOpenTest(){
        $response = $this->get('/api/wallet/open');
        $response->assertStatus(200);
    }*/
}
