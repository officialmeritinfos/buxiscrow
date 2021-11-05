<?php

namespace Database\Factories;

use App\Models\Businesses;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Businesses::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user'=>2,
            'name'=>$this->faker->name(),
            'transactionRef'=>Str::random(10),
            'transId'=>Str::random(10),
            'currency'=>'NGN',
            'amount'=> rand(100,1000000),
            'transactionType'=>2,
        ];
    }
}
