<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PackageEvent>
 */
class PackageEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data' => $this->faker->dateTime(),            
            'local' => $this->faker->city,
            'status' => $this->faker->word,
            'sub_status' => json_encode($this->faker->words(3)),
        ];
    }
}
