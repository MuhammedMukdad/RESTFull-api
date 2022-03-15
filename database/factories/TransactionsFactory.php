<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionsFactory extends Factory
{
    protected $model=\App\Models\Transactions::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $seller=Seller::has('products')->get()->random();
        $buyer=User::all()->except($seller->id)->random();
        return [
            'quantitiy'=>$this->faker->numberBetween(1,3),
            'buyer_id'=>$buyer->id,
            'product_id'=>$seller->products->random()->id,
        ];
    }
}
