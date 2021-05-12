<?php

namespace Tests\Integration\Controller;

use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class OpenWalletControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function openWalletForValidUserId(){
        Wallet::factory(Wallet::class)->create();

        $response = $this->postJson('/api/wallet/open', ['user_id' => '1']);

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['wallet_id' => '2']);
    }

    /** @test */
    public function walletNotOpenForNullUser(){
        Wallet::factory(Wallet::class)->create();

        $response = $this->postJson('/api/wallet/open');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error'=>'User not found']);
    }

    /** @test */
    public function walletNotOpenForEmptyUser(){
        Wallet::factory(Wallet::class)->create();

        $response = $this->postJson('/api/wallet/open', ['user_id' => '']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error'=>'User not found']);
    }



}
