<?php

namespace Database\Factories;

use App\Models\Activities;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivitiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activities::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'activity_type' => $this->faker->word,
        'activity_id' => $this->faker->word,
        'activity_message' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
