<?php

namespace Tests\Integration\Controller;

use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetWalletControllerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    /*public function noWalletFoundForGivenId(){
        Wallet::factory(Wallet::class)->create();

        $response = $this->get('/api/wallet/5');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Coins not found']);
    }*/

    /** @test */
    /*public function noCoinNameFoundForGivenId(){
        Wallet::factory(Wallet::class)->create();

        $response = $this->get('/api/wallet/5');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Coins not found']);
    }*/

}
