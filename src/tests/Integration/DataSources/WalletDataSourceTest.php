<?php

namespace Tests\Integration\DataSources;

use App\DataSource\database\WalletDataSource;
use App\Http\Controllers\GetUserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WalletDataSourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testExample(){
        $response = $this->get('/');
        $response->assertStatus(200);
        /*$walletDAO = new WalletDataSource();
        $output = $walletDAO->getWalletById('1');
        $this->assertNotEmpty($output);*/
    }
}
