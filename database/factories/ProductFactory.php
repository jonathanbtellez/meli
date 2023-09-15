<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

	public function categoryId($category)
	{
		return $this->state([
			'category_id' => $category->id
		]);
	}
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
	public function definition()
	{
		return [
			'name' => $this->faker->firstName,
			'description' => $this->faker->paragraph(3),
			'stock' => $this->faker->randomDigit(),
			'price' => $this->faker->randomFloat(),
			// 'category_id' => $this->faker->randomElement([1,2,3,4,5])
		];
	}
}

