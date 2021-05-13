<?php

namespace Tests\Unit\Services;

use App\DataSource\Database\CoinDataSource;
use App\Services\SellCoinService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class SellCoinServiceTest extends TestCase{


    private $coinDataSource;
    private $sellCoinService;

    protected function setUp():void{
        parent::setUp();
        $prophet = new Prophet();
        $this->coinDataSource = $prophet->prophesize(CoinDataSource::class);
        $this->sellCoinService = new SellCoinService($this->coinDataSource->reveal());
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample(){
        //$response = $this->get('/');
        $this->sellCoinService->getDiferenceBetweenAmountCoinThatIHaveAndAmounCoinIWantToSell()
            ->findByEmail($email)->shouldBeCalledOnce()->willReturn($user);
        //$response->assertStatus(200);
    }
}
