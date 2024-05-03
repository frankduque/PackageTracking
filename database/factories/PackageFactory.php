<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PackageEvent;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => Str::random(20), // Gerar um código único usando a função Str::random()
            'host' => $this->faker->domainName,
            'quantidade' => $this->faker->randomNumber(2),
            'servico' => $this->faker->word,
            'ultimo' => $this->faker->dateTime(),
        ];
    }

    public function withEvents()
    {
        return $this->has(PackageEvent::factory()->count(3));
    }
}
