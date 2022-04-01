<?php

namespace Database\Factories;

use App\Models\Units;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Units::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit' => $this->faker->word,
        'make' => $this->faker->word,
        'model' => $this->faker->word,
        'year_model' => $this->faker->word,
        'traction_force' => $this->faker->word,
        'customer' => $this->faker->word
        ];
    }
}
