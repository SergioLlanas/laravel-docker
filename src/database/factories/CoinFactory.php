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
            'id_transaction' => 1,
            'coin_id' => '1',
            'name' => 'Bitcoin',
            'symbol' => 'BIT',
            'wallet_id' => '1',
            'amount' => 25.4,
            'value_usd' => 63.88
        ];
    }
}
