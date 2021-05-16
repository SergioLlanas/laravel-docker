<?php

namespace Tests\Integration\Controller;

use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class OpenWalletControllerTest extends TestCase{

    use RefreshDatabase;

    protected function setUp():void{
        parent::setUp();
        Wallet::factory(Wallet::class)->create();
    }

    /** @test  */
    public function openWalletForValidUserId(){
        $response = $this->postJson('/api/wallet/open', ['user_id' => '1']);

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['wallet' => ["created_at"=>null,"transaction_balance"=>"0.0","updated_at"=>null,"user_id"=>"1","wallet_id"=>"2"]]);
    }

    /** @test */
    public function walletNotOpenForNullUser(){
        $response = $this->postJson('/api/wallet/open');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error'=>'User not found']);
    }

    /** @test */
    public function walletNotOpenForEmptyUser(){
        $response = $this->postJson('/api/wallet/open', ['user_id' => '']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error'=>'User not found']);
    }
}
