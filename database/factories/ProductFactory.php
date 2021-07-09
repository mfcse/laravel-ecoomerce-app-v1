<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => random_int(1, 10),
            'title' => $this->faker->name(),
            'description' => $this->faker->text(50),
            'price' => $this->faker->randomNumber(),
        ];
    }
}