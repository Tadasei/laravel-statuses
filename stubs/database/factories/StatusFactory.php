<?php

namespace Database\Factories;

use App\Enums\StatusableType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			"statusable_type" => fake()->randomElement(StatusableType::class)
				->value,

			"name" => fake()->unique()->word(),

			"color" => fake()->hexColor(),

			"is_initial" => fake()->boolean(),

			"is_final" => fake()->boolean(),
		];
	}
}
