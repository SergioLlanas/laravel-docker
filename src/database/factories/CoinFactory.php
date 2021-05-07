<?php


namespace Database\Factories;


use App\Models\Coin;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoinFactory extends Factory{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'coin_id' => '1',
            'nameCoin' => 'Bitcoin',
            'symbol' => 'BIT',
            'wallet_id' => '1',
            'buy_price' => 5.2,
            'amount_coins' => 25.4
        ];
    }
}
