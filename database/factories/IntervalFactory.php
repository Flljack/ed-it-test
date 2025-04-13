<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interval>
 */
class IntervalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->numberBetween(0, 100_000);
        $isInfinite = $this->faker->boolean(15);
        return [
            'start' => $start,
            'end' => $isInfinite ? null : $start + $this->faker->numberBetween(1, 1000),
        ];
    }
}
